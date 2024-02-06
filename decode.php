<?php

function decodeTransactionHex($transactionHex)
{

    $version = hexdec(substr($transactionHex, 0, 8));

    $inputCount = hexdec(substr($transactionHex, 8, 2));
    $inputs = [];
    $offset = 10;

    for ($i = 0; $i < $inputCount; $i++) {
        $inputs[] = substr($transactionHex, $offset, 64);
        $offset += 64;
    }

    $outputCount = hexdec(substr($transactionHex, $offset, 2));
    $outputs = [];
    $offset += 2;

    for ($i = 0; $i < $outputCount; $i++) {
        $outputs[] = hexdec(substr($transactionHex, $offset, 16));
        $offset += 16;
    }

    $locktime = hexdec(substr($transactionHex, $offset, 8));


    echo "Version: $version\n";

    foreach ($inputs as $i => $input) {
        echo "Input " . ($i + 1) . ": $input\n";
    }

    foreach ($outputs as $i => $output) {
        echo "Output " . ($i + 1) . ": $output satoshis\n";
    }

    echo "Locktime: $locktime\n";
}


$transactionHex = "020000000001010ccc140e766b5dbc884ea2d780c5e91e4eb77597ae64288a42575228b79e234900000000000000000002bd37060000000000225120245091249f4f29d30820e5f36e1e5d477dc3386144220bd6f35839e94de4b9cae81c00000000000016001416d31d7632aa17b3b316b813c0a3177f5b6150200140838a1f0f1ee607b54abf0a3f55792f6f8d09c3eb7a9fa46cd4976f2137ca2e3f4a901e314e1b827c3332d7e1865ffe1d7ff5f5d7576a9000f354487a09de44cd00000000";


decodeTransactionHex($transactionHex);
