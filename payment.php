<?php

header("Access-Control-Allow-Origin: *");

if ($_SERVER['HTTP_REFERER'] == "http://") {

}

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(5);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$paramSource = $_POST;

if (!isset($paramSource["apdu"])) {
        $paramSource = $_GET;
}

$address = $paramSource["terminalIP"];
$port = $paramSource["terminalPort"];
$apdu = $paramSource["apdu"];

$fp = fsockopen($address, $port, $errno, $errstr, 2);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {

    $string = hex2bin($apdu);
    $output = unpack('C*', $string);

    $chars = array_map("chr", $output);
    $stringoutput = join($chars);

    stream_set_timeout($fp, 2);

    fwrite($fp, $stringoutput);

    $buffer = fgets($fp, 3);
// http://localhost/payment.php?terminalIP=192.168.2.93&port=5577&apdu=060109040000000000011940

    $result = bin2hex($buffer);
    $length = "";
    $detail = "";
    if ($result == "060f") {
//      $length = fgets($fp, 1+1);
//      $length = bindec($length);
//      $detail = fgets($fp, $length + 1);
    }

    echo $result.$length.$detail;

    fclose($fp);
}
?>
