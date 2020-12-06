<?php
    // Will need to set these variables to valid a MerchantID and Password
// These were obtained during sign up
$MerchantID = "wwwexa-7088897";
$Password = "paYmenT5en5e3";

// This is the domain (minus any host header or port number for your payment processor
// e.g. for "https://gwX.paymentprocessor.net:4430/", this should be "paymentprocessor.net"
// e.g. for "https://gwX.thepaymentgateway.net/", this should be "thepaymentgateway.net"
$PaymentProcessorDomain = "https://gw1.paymentsensegateway.com/";
// This is the port that the gateway communicates on -->
// e.g. for "https://gwX.paymentprocessor.net:4430/", this should be 4430
// e.g. for "https://gwX.thepaymentgateway.net/", this should be 443
$PaymentProcessorPort = 4430;

// This is used to generate the Hash Keys that detect variable tampering
// You should change this to something else
$SecretKey = "RvWpi/2twdRCAeMEasmrmP6SDoIhxP4Y23DNzn+EmT/RX6NWZus=";

if ($PaymentProcessorPort == 443) {
    $PaymentProcessorFullDomain = $PaymentProcessorDomain . "/";
} else {
    $PaymentProcessorFullDomain = $PaymentProcessorDomain . ":" . $PaymentProcessorPort . "/";
}
