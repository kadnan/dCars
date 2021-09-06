/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
let currentAccount = null;
let web3;
let abi;

function handleAccountsChanged(accounts) {
    console.log('Calling HandleChanged')

    if (accounts.length === 0) {
        console.log('Please connect to MetaMask.');
        $('#enableMetamask').html('Connect with Metamask')
    } else if (accounts[0] !== currentAccount) {
        currentAccount = accounts[0];
        $('#enableMetamask').html(currentAccount)
        $('#status').html('')

        if(currentAccount != null) {
            // Set the button label
            $('#enableMetamask').html(currentAccount)
        }
    }
    console.log('WalletAddress in HandleAccountChanged ='+currentAccount)
}

function connect() {
    console.log('Calling connect()')
    ethereum
        .request({ method: 'eth_requestAccounts' })
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

$(document).ready(function () {

    $('#enableMetamask').click(function() {
        // alert('Hi Bay');
        connect()
    });

    $('#btnReserved').click(function () {
        var data_id = $(this).data('carid');
        var url = `http://localhost:8000/car/${data_id}/reserve/`;

        $.getJSON(url,function(result){
            console.log(result.STATUS)
        });


    });

    connect()


});