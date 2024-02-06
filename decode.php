#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use BitWasp\Bitcoin\Address\AddressCreator;


if ($argc != 2) {
    echo "Usage: php decode.php <transaction_hex>\n";
    exit(1);
}

$transactionHex = $argv[1];

$addrCreator = new AddressCreator();

function decoderaw($raw) {
    global $addrCreator; // Use the global variable in the function

    $tx = TransactionFactory::fromHex($raw);

    $result['txid'] = $tx->getTxId()->getHex();
    $result['version'] = $tx->getVersion();
    // return $tx->getVersion();
    foreach ($tx->getOutputs() as $key => $output) {
        try {
            $result['outputs'][$key]['address'] = $addrCreator->fromOutputScript($output->getScript())->getAddress();
        } catch (\Exception $e) {
            $result['outputs'][$key]['address'] = 'Newly Generated Coins';
        }
        $result['outputs'][$key]['value'] = $output->getValue() / 100000000;
    }
    

    foreach ($tx->getInputs() as $key => $input) {
        $result['inputs'][$key]['txid'] = ($input->getOutPoint()->getTxId()->getHex());
        $result['inputs'][$key]['vout'] = $input->getOutPoint()->getVout();
        // $result['inputs'][$key]['address'] = $addrCreator->fromString($input->getScript())->getAddress();
    }

    // $result['value'] = $tx->getValueOut() / 100000000; // SAT TO BTC

    $result['locktime'] = $tx->getLockTime();

    return $result;
}

// echo the result
echo json_encode(decoderaw($transactionHex), JSON_PRETTY_PRINT);
