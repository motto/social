<?php
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Enum\Param;
class GOB {
    public static $coinKey='duqWXbUlCKH8qNg8';
    public static $coinSecret='DE4hteGw1nAzRwpxh4hPVN8dwRBjSBCL';
    public static $client=null;
}
$configuration =Configuration::apiKey(GOB::$coinKey, GOB::$coinSecret);
//GOB::$client = Client::create($configuration);
$client = Client::create($configuration);
//$client->enableActiveRecord();
//$account = new Account();
//$accounts = $client->getAccounts([Param::FETCH_ALL => true]);
$accounts = $client->getAccounts();

echo '<html>';



foreach ($accounts as &$account) {//1AxtQd562fqp5L8xsnxWxPXgxi4BgKFH8L gg
    $balance = $account->getBalance();
    // $tarcaid= $account->getAddresses()->getFirstId();
    $adressid=$client->getAccountAddresses($account)->getFirstId();
    $address=$client->getAccountAddress($account,$adressid)->getAddress();
    // $tarca=$client->getAccountAddresses($account)->getFirstId();

    echo $address. ":--------- " . $account->getId() . ": " . $account->getName() . ": " .  $balance->getAmount() . $balance->getCurrency() .  "<br/>";
}


echo '</html>';