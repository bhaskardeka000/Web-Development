<?php
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$ip_address =  get_client_ip();



//Code to get location details of an ip address
// (A) SETTINGS + URL
$settings = [
  "apiKey" => "0000576e05f64b71b00bec01fa5c3c57",
  "ip" => $ip_address,
  "lang" => "en",
  "fields" => "*"
];
$url = "https://api.ipgeolocation.io/ipgeo?";
foreach ($settings as $k=>$v) { $url .= urlencode($k)."=".urlencode($v)."&"; }
$url = substr($url, 0, -1);
  
// (B) INIT CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
// (C) CURL FETCH
$result = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }
else {
  $info = curl_getinfo($ch);
  $result = json_decode($result, 1);
print_r($result);

$country_name = $result['country_name'];
$current_time = $result['time_zone']['current_time'];

}
curl_close($ch);

$check_ip_address = mysqli_query($con, "select * from website_visitors where ip_address = '$ip_address'");
if(mysqli_num_rows($check_ip_address)>0){
    mysqli_query($con, "update website_visitors set ip_address = '$ip_address', country = '$country_name', visiting_date_time = '$current_time'");
}
else{
mysqli_query($con, "insert into website_visitors(ip_address, country, visiting_date_time) values('$ip_address', '$country_name', '$current_time ')");
}
?>