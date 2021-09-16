/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
let currentAccount = null;

let abi;

let contactAddress = '0xb78781314F125C69edbCbbb7946eb0E0dCA88597'; // dCars deployed NFT address

function addTransaction(tx_hash, data) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('http://localhost:8000/transaction/add', {tx_hash: tx_hash, data: JSON.stringify(data)}, function (result) {
        console.log(result);
    });
}

async function payEther(car_price) {
    let isTransaction = false;
    let MERCHANT_ACCOUNT = '0x3595B4054E1A86Ef5D86fc4A03A58fc998a26d5a'
    let eth_wei = ethUnit.toWei(car_price, 'ether');
    // console.log('ETH AMOUNT ='+eth_wei)
    // console.log('ETH IN HEX ='+eth_wei.toString(16))
    let invoice_id_hex = '494e562d3030';

    const transactionParameters = {
        nonce: '0x00', // ignored by MetaMask
        gasPrice: '0x09184e72a000', // customizable by user during MetaMask confirmation.
        gas: '0x22710', // customizable by user during MetaMask confirmation.
        to: MERCHANT_ACCOUNT, // Required except during contract publications.
        from: currentAccount, // must match user's active address.
        value: eth_wei.toString(16),
        data: invoice_id_hex, // You must use a random Invoice ID. it is for Demo Purpose Only
        chainId: '0x3', // Used to prevent transaction reuse across blockchains. Auto-filled by MetaMask.
    };
    // console.log(transactionParameters)

    if (currentAccount != null) {
        let txHash = null;
        try {
            txHash = await ethereum.request({
                method: 'eth_sendTransaction',
                params: [transactionParameters],
            });
            console.log(txHash)
        } catch (error) {
            console.log(error.code)
            console.log(error)
        }
        // console.log('Printing MetaMask Result')
        // console.log(txHash)
        if (txHash != null) {
            addTransaction(txHash, {'invoice_id': invoice_id_hex})
            isTransaction = true;
        }
    }

    return isTransaction
}

function handleAccountsChanged(accounts) {
    console.log('Calling HandleChanged')

    if (accounts.length === 0) {
        console.log('Please connect to MetaMask.');
        $('#enableMetamask').html('Connect with Metamask')
    } else if (accounts[0] !== currentAccount) {
        currentAccount = accounts[0];
        $('#enableMetamask').html(currentAccount)
        $('#status').html('')

        if (currentAccount != null) {
            // Set the button label
            $('#enableMetamask').html(currentAccount)
        }
    }

    let url = 'http://localhost:8000/set_wallet/' + currentAccount;

    $.getJSON(url, function (result) {
        console.log(result)
    });
    console.log('WalletAddress in HandleAccountChanged =' + currentAccount)

    //Set AJAX request to insert value in DB
}

function connect() {
    console.log('Calling connect()')
    ethereum
        .request({method: 'eth_requestAccounts'})
        .then(handleAccountsChanged)
        .catch((err) => {
            if (err.code === 4001) {
                // EIP-1193 userRejectedRequest error
                // If this happens, the user rejected the connection request.
                console.log('Please connect to MetaMask.');
                $('#status').html('You refused to connect Metamask')
            } else {
                console.error(err);
            }
        });
}

/**
 * This function will call contract's mintNFT function and return hashTX and Token URI
 */
async function createNFT(uri, account) {
    let web3;
    let tx_hash = null;
    let token_id = 0;
    try {
        console.log('Inside createNFT');
        // console.log(abi);
        console.log(account);
        web3 = new Web3(new Web3.providers.HttpProvider("HTTP://127.0.0.1:7545"));
        const contract = new web3.eth.Contract(
            abi,
            contactAddress
        );

        tx_hash = await contract.methods.mintNFT(uri).send({from: account, gas: 1000000}).then(function (result) {
            console.log(result);
            let tx = result.transactionHash;
            return tx
        });
        console.log('Hash Outside:- ' + tx_hash)

        let receipt = await web3.eth.getTransactionReceipt(tx_hash)
            .then(function (result) {
                return result
            });

        /**
         * In order to grab the returned TokenID we need to grab info from logs.
         */
        let topics = receipt['logs'][0]['topics'];
        let tokenIdHex = topics[3].toString(10);
        token_id = parseInt(tokenIdHex, 16)

    } catch (error) {
        console.log('Exception in createNFT')
        console.log(error)
    }
    finally {
        web3 = null;
    }
    return {'tx_hash': tx_hash, 'token_id': token_id};
}

let base_url = 'http://localhost:8000/';
$.getJSON(base_url + "dCars.json", function (result) {
    abi = result.abi;
});

$(document).ready(function () {

    $('#enableMetamask').click(function () {
        // alert('Hi Bay');
        connect()
    });

    $('#btnReserved').click(function () {
        let data_id = $(this).data('carid');
        let url = `http://localhost:8000/car/${data_id}/reserve/`;

        $.getJSON(url, function (result) {
            console.log(result.STATUS)
        });


    });

    $('#btnBuy').click(function () {
        let registered_wallet = $(this).data('wallet');
        let car_price = $(this).data('price');
        let car_id = $(this).data('carid');
        let meta_url = `http://localhost:8000/nft/meta/${car_id}.json`;
        let nftid = $(this).data('nftid');

        console.log(registered_wallet);
        console.log('Current Account = ' + currentAccount)

        /*
         Data Attribute of Buy button are set only if session var is set which
         is only possible if you are logged in
         */
        if (registered_wallet == '') {
            alert('You are not logged in')
            return false
        }

        if (registered_wallet.toLowerCase() != currentAccount.toLowerCase()) {
            alert('You are using the wallet which is not registered with us. Your registered wallet address is:- ' + registered_wallet + ' while you are connected with the wallet address:-' + currentAccount)
            return false
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * This function will deduct Ether price of the Car
         */
        payEther(car_price).then(function (result) {
            console.log('PayEther Return Value')
            if (result) {
                console.log('Payment fetched, lets Mint NFT')
                /**
                 * Add NFT Code Here
                 */

                let output = createNFT(meta_url, currentAccount).then(function (result) {
                    console.clear()
                    let transaction_hash = result.tx_hash
                    let token_id = result.token_id

                    const mint_url = "http://localhost:8000/nft/minted";
                    console.log(nftid + '-' + transaction_hash + '-' + token_id + '-' + car_id, currentAccount, 'dCar');
                    console.log('Mint Transaction Hash:- ' + transaction_hash)

                    $.post(mint_url, {
                            nft_id: nftid,
                            event: "mint",
                            to: currentAccount,
                            from: 'dCars',
                            tx_hash: transaction_hash,
                            token_id: token_id,
                            car_id: car_id
                        },
                        function (data) {
                            console.log(data);
                        }
                    );
                });

                alert('You successfully bought this car. The car ownership transferred to you.')
            } else {
                console.log('User do not want NFT!!!')
            }
        });

    });
    connect()

});