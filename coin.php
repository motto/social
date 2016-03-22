<?php
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Enum\Param;
//küldés---------
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;

class GOB {
    public static $coinKey='duqWXbUlCKH8qNg8';
    public static $coinSecret='DE4hteGw1nAzRwpxh4hPVN8dwRBjSBCL';
    public static $client=null;
    public static $coin_gyüjtő='1AxtQd562fqp5L8xsnxWxPXgxi4BgKFH8L'; //ggg bitcoinaddess
}
$configuration =Configuration::apiKey(GOB::$coinKey, GOB::$coinSecret);
//GOB::$client = Client::create($configuration);
$client = Client::create($configuration);
//$accounts = $client->getAccounts();
//$client->enableActiveRecord();
//$account = new Account();
//$accounts = $client->getAccounts([Param::FETCH_ALL => true]);
///$account= GOB::$client->getAccount($accountid);

//$response = $client->createAccountTransaction(, $transaction);`
//user 2: 0.00020

$account= $client->getAccount('2f2e973e-1323-5755-8ecb-fa9c7576b82a');
$transaction = Transaction::send([
    'toBitcoinAddress' => '1QCnJHPGmw9pMestTF8kfV5i1dvBc3nyDK',
    'amount'           => new Money(0.0001, CurrencyCode::BTC),
    'description'      => '',
    'fee'              => '0.0001' // only requi..
]);


try {
    $client->createAccountTransaction($account,$transaction);
    echo 'sikerült';
    $response=$client->decodeLastResponse();
  if($response['data']['status'] == 'pending'){}


} catch (Exception $e) {
 // echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo 'nemsikerült';
    $response=$client->decodeLastResponse();
    // if($response['data']['status'] == 'pending')
print($response);
   // echo 'Done:'.$response['data']['status'];
}


///print_r($response);
//echo
//print_r($response);
/*
if($response->)
	{
		echo 'Done.';
	}
else{  echo 'nemsikerült.';  }

*/



/*
//coin küldés-----------------------------
//$account=$client->getAccount('3189b9e0-a5d6-5f97-a7d9-51de62fcafaa');


//echo '<html>';
$transaction = Transaction::send([
    'toBitcoinAddress' => '1AxtQd562fqp5L8xsnxWxPXgxi4BgKFH8L',
    'amount'           => new Money(0.001, CurrencyCode::BTC),
    'description'      => 'Your first bitcoin!',
    'fee'              => '0.0001' // only required for transactions under BTC0.0001
]);

$client->createAccountTransaction($account, $transaction);
---------------------------------------
*/

/*
//adatok tömbbe-----------------------------------------------------
foreach ($accounts as &$account) {//1AxtQd562fqp5L8xsnxWxPXgxi4BgKFH8L gg
    //3781accb-7641-5885-a667-eecd38f0bf9a
    $balance = $account->getBalance();
   // $tarcaid= $account->getAddresses()->getFirstId();
    $adressid=$client->getAccountAddresses($account)->getFirstId();
    $address=$client->getAccountAddress($account,$adressid)->getAddress();
   // $tarca=$client->getAccountAddresses($account)->getFirstId();

   echo $address. ":--------- " . $account->getId() . ": " . $account->getName() . ": " .  $balance->getAmount() . $balance->getCurrency() .  "<br/>";
}
*/

//echo '</html>';