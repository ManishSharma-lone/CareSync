<?php
header('Content-Type: application/json');
$apiKey = "fb2a6690-b25f-4e4e-8ad5-719dc3b9d977";
$input = json_decode(file_get_contents('php://input'), true);
$aadhaar = $input['aadhaar'] ?? '';

if(empty($aadhaar)){
    echo json_encode(["success"=>false, "error"=>"Aadhaar number is required"]);
    exit;
}

$url = "https://sandbox.setu.co/aadhaar/send-otp";
$data = ["aadhaar_number"=>$aadhaar];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>