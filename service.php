<?php


// Define the service URL and the WSDL file
$service_url = "http://example.com/service.php";
$wsdl_file = "http://example.com/service.wsdl";
$client = new SoapClient($wsdl_file);
$customer_id = 12345;
$customers = array("ahmad", "asghar","hadi");
$response = $client->callService($customer_id);

// Check if the service call was successful
if ($response->status == "success") {
    $payment = $response->payment;
    $db= new mysqli("localhost","username","password","database");
    $sql = "select wallet from customers where id = $customer_id";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $wallet = $row["wallet"];


    // Subtract the payment
    $wallet -= $payment;
    $sql = "update customers set wallet = $wallet where id = $customer_id";
    $db->query($sql);
    $db->close();
    echo "Service call successful. Payment of $$payment subtracted from your wallet.";
}
else {
    // Echo an error message
    echo "Service call failed. Reason: " . $response->reason;
}