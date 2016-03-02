<?php
//require 'coinbase/src/Client.php';
//require 'coinbase/src/Configuration.php';
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;


$apiKey='duqWXbUlCKH8qNg8';
$apiSecret='DE4hteGw1nAzRwpxh4hPVN8dwRBjSBCL';

$configuration =Configuration::apiKey($apiKey, $apiSecret);
$client = Client::create($configuration);
$client->enableActiveRecord();


//$accounts = $client->getAccounts();
//$buyPrice = $client->getBuyPrice();


/*
$client->enableActiveRecord();
$accounts = $client->getAccounts();
foreach ($accounts as &$account) {
    $balance = $account->getBalance();
    echo $account->getName(). ": " . $balance->getAmount(). ": " . $balance->getCurrency() .": ". $account->getId(). ": " . $account->getAddress($account->getId()) ."----------------\r\n";
   // print_r($account->getAddress($account->getId()));
   // print_r($client->getAccountTransactions($account));
}
*/

//eddig jó $cc tartalmazza a tárca címet------------
//$valletid="3189b9e0-a5d6-5f97-a7d9-51de62fcafaa";
//$adreesid=780e8e89-45db-5e7d-bf1f-e340b8ebacc4
//tárcacím:18x88ewHF18rmwjsiumLbYB2jn8WQK1yrd
//$account = $client->getAccount($valletid);
//$adressid=$client->getAccountAddresses($account)->getFirstId();
//echo $adressid.'----------';
//print_r($client->getAccountAddress($account,$adressid)->getAddress());

////-------------------------------------------------------------
$account = new Account();
$account->setName('ggg');
$client->createAccount($account);

$address = new Address();
$client->createAccountAddress($account, $address);
$adressid=$client->getAccountAddresses($account)->getFirstId();
print_r($client->getAccountAddress($account,$adressid)->getAddress());
//14iBfNefGdpAJPYkuRPtUAfPXRpfPnUxtA

/*
(
 [previousUri:Coinbase\Wallet\Resource\ResourceCollection:private] => [nextUri:Coinbase\Wallet\Resource\ResourceCollection:private] => [resources:Coinbase\Wallet\Resource\ResourceCollection:private] =>
    Array ( [0] =>
            Coinbase\Wallet\Resource\Address Object
            (
                [address:Coinbase\Wallet\Resource\Address:private] => 18x88ewHF18rmwjsiumLbYB2jn8WQK1yrd
                [name:Coinbase\Wallet\Resource\Address:private] =>
                [callbackUrl:Coinbase\Wallet\Resource\Address:private] =>
                [createdAt:Coinbase\Wallet\Resource\Address:private] =>
                    DateTime Object
                        (
                        [date] => 2016-02-27 23:50:26
                        [timezone_type] => 2
                        [timezone] => Z
                        )
                [updatedAt:Coinbase\Wallet\Resource\Address:private] =>
            DateTime Object
                (
                [date] => 2016-02-27 23:50:26
                [timezone_type] => 2
                [timezone] => Z
                )
            [id:Coinbase\Wallet\Resource\Resource:private] =>780e8e89-45db-5e7d-bf1f-e340b8ebacc4
            [resource:Coinbase\Wallet\Resource\Resource:private] => address
            [resourcePath:Coinbase\Wallet\Resource\Resource:private] => /v2/accounts/3189b9e0-a5d6-5f97-a7d9-51de62fcafaa/addresses/780e8e89-45db-5e7d-bf1f-e340b8ebacc4
            [rawData:Coinbase\Wallet\Resource\Resource:private] =>
                Array
                ( [id] => 780e8e89-45db-5e7d-bf1f-e340b8ebacc4
                [address] => 18x88ewHF18rmwjsiumLbYB2jn8WQK1yrd
                [name] =>
                [created_at] => 2016-02-27T23:50:26Z
                [updated_at] => 2016-02-27T23:50:26Z
                [resource] => address
                [resource_path] => /v2/accounts/3189b9e0-a5d6-5f97-a7d9-51de62fcafaa/addresses/ 780e8e89-45db-5e7d-bf1f-e340b8ebacc4
                [callback_url] =>
                )
            )
          )
)


*/












//$address = new Address();
//$address->  getAddress($account);


//$client->createAccountAddress($account, $address);

//$valletid="3189b9e0-a5d6-5f97-a7d9-51de62fcafaa";
//$tarca=$client->getAccount($valletid);
//$client->getAccountAddress($tarca,$valletid);

//print_r($tarca);


//echo $accu->getAddress($valletid);
//echo $accu->getAccountAddress($accu,$adressid);

//$rates = $client->getExchangeRates('btc');
//echo $rates['rates']['HUF'];
/*
 //tárca készítés működik------------------------------------
$account = new Account();
$account->setName('uj tarca');
$client->createAccount($account);

$address = new Address();
$client->createAccountAddress($account, $address);
*/


/*
$configuration = Configuration::apiKey($coinbaseAPIKey,$coinbaseAPISecret);
$configuration->setApiUrl(Configuration::SANDBOX_API_URL);
$client = Client::create($configuration);
$accounts = $client->getAccounts();
foreach ($accounts as &$account) {
    $balance = $account->getBalance();
    echo $account->getName() . ": " . $balance->getAmount() . $balance->getCurrency() .  "\r\n";
    print_r($client->getAccountTransactions($account));
}

$coinbase = Coinbase::withApiKey($coinbaseAPIKey, $coinbaseAPISecret);
echo $coinbase->getBalance() . " BTC";
$rates = $coinbase->getExchangeRate();

echo $rates->btc_to_usd;
// is the same as...
echo $coinbase->getExchangeRate('btc', 'usd');
$paymentButton = $coinbase->createButton(
    "Order #1",
    "19.99",
    "EUR",
    "TRACKING_CODE_1",
    array(
        "description" => "1 item at 19.99"
    )
);
*/