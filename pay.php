<?php
$api_key = 'MK_TEST_1V27PDXTB0';
$api_secret = 'FL8MFXMXXGGNZH7842RY7P2Q5ABPQW7Y';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://sandbox.monnify.com/api/v1/payments",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode(array(
    "amount" => 1000,
    "customerName" => "John Doe",
    "customerEmail" => "johndoe@example.com",
    "paymentReference" => "ORD-123456",
    "paymentDescription" => "Test payment",
    "currencyCode" => "NGN",
    "redirectUrl" => "https://example.com/redirect",
    "paymentMethods" => ["CARD"],
    "metadata" => [
      "custom_fields" => [
        [
          "field_name" => "product_name",
          "field_value" => "Test product"
        ]
      ]
    ]
  )),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Basic ".base64_encode($api_key.':'.$api_secret)
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $response = json_decode($response, true);
  var_dump($response); // Debugging statement
  if (!empty($response)) {
    if(isset($response["status"]) && isset($response["responseMessage"])){
      if($response["status"] == "success"){
        // Redirect to the payment URL
        header("Location: ".$response["responseBody"]["paymentLink"]);
      }else{
        // Handle error
        echo $response["responseMessage"];
      }
    } else {
      echo "Invalid API response";
    }
  } else {
    echo "Empty API response";
  }
}


