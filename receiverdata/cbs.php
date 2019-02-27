<?php
 
$apiKey = "tduisbgkfwwxnikktbtq";
$data = array(
    "radioType" => "gsm",
    "cellTowers" => array(
        array(
            "mobileCountryCode" => 240,
            "mobileNetworkCode" => 1,
            "locationAreaCode" => 3012,
            "cellId" => 11950
        )
    )
);
 
// Make request to server
$c = curl_init("https://cps.combain.com?key=$apiKey");
curl_setopt_array($c, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    CURLOPT_POSTFIELDS => json_encode($data)
));
$response = curl_exec($c);
if ($response === FALSE) {
    die(curl_error($c));
}
 
// Decode result
$result = json_decode($response, true);
if (isset($result['location'])) {
    print "Returned location: ".$result['location']['lat'].", ".$result['location']['lng'];
} else {
    print "The following error occurred: ".$result['error']['message'];
}
 
?>