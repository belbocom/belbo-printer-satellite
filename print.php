<?php 
header("Access-Control-Allow-Origin: *");
$file = "printme.txt";
$current = base64_decode($_GET["text"]);
file_put_contents($file, $current);
copy($file, $_GET["printerIP"]);
?>console.log("Successfully printed");
