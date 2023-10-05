<?php 
//   function getFullURL(){
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443)? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    echo $protocol.$host.$uri;
//   }


// <?php 
// if(isset($_POST['submit'])){
// ?>
 
//  <script>
//    window.onload = function() {
//         Object.assign(document.createElement("a"), {
//         target: "_blank",
//         href: "all_products.php"
//         }).click();
//     };
//     </script> 
// <?php
// }
// ?>

// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
// </head>
// <body>
//     <form action="check.php" method="post">
//         <input type="text" value="21" name="age">
//         <input type="submit" name="submit" value="SUBMIT">
// </form>
// </body>
// </html>
?>

<!-- session_start();
// $_SESSION['pids'] = array();
// array_push($_SESSION['pids'], uniqid());

// $_SESSION['pids'][] = uniqid();
print_r($_SESSION['csrf_token_for_login']);
// $search = '64d930c6e2882';
// if(in_array($search, $_SESSION['pids'])){
// echo "Value found: ".$search;
// }
// else{
// echo "No value found!"; -->


<?php
session_start();

// $_SESSION['csrf_token']['login_form'][] = uniqid();
// $array = $_SESSION['csrf_token']['login_form'];
// $index = array_search('64dcb8372f938', $_SESSION['csrf_token']['login_form']);
// unset($_SESSION['csrf_token']['login_form'][$index]);
print_r($_SESSION['csrf_token']);
// $_SESSION['pids'] = array();
// array_push($_SESSION['pids'], uniqid());
// foreach($_SESSION['csrf_token']['logout_form'] as $key=> $value){
//     unset($_SESSION['csrf_token']['logout_form'][$key]);
    
// }

// $_SESSION['pids'][] = uniqid();
// print_r($_SESSION['csrf_token_for_login']);
// $search = '64d930c6e2882';
// if(in_array($search, $_SESSION['pids'])){
// echo "Value found: ".$search;
// }
// else{
// echo "No value found!";
// }
?>

session_start();
//         if(!isset($_SESSION['last_regeneration'])){
//             $logout_form_generated_token = uniqid();
//             $_SESSION['csrf_token']['logout_form'][] = $logout_form_generated_token;
//             $_SESSION['last_regeneration'] = time();
//         }
//         else{
//             $interval = 60 * 1;
//             if(time() - $_SESSION['last_regeneration']>= $interval){
//                 $logout_form_generated_token = uniqid();
//                 $_SESSION['csrf_token']['logout_form'][] = $logout_form_generated_token;
//                 $_SESSION['last_regeneration'] = time();
//             }
//             else{
//                 $logout_form_generated_token = $_SESSION['csrf_token']['logout_form'][0];
//             }
//         }
// echo $logout_form_generated_token;
print_r($_SESSION['csrf_token']);

<?php 
// $message = "How are you doing?";
$message = 3;

// $secretKey =  random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
// $secretKeyHex = sodium_bin2hex($secretKey);
// $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
// $cipherText = sodium_crypto_secretbox($message, $nonce, $secretKey);
// $result = sodium_bin2base64($nonce.$cipherText, SODIUM_BASE64_VARIANT_ORIGINAL);
// echo $result;


//ENCRYPT FUNCTION
function encrypt($data){
    $key = 'hyuiplmocvyupqcrrmgpldskipmolvgkrtumnvluetrxczmpruvgkds'; 
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
    
//DECRYPT FUNCTION
function decrypt($data){
    $key = 'hyuiplmocvyupqcrrmgpldskipmolvgkrtumnvluetrxczmpruvgkds'; 
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
$encrypted_message = encrypt($message);
$decrypted_message = decrypt($encrypted_message);
echo $encrypted_message;
echo "<br>";
echo $decrypted_message;
?>



<?php
// $iv = openssl_cipher_iv_length($cipher);
function encrypt($data){
$key = "klpqortbnwvxopliuytrv";
$cipher = "AES-256-CBC";
$iv = openssl_random_pseudo_bytes(16);
$options = 0;
$data = openssl_encrypt($data, $cipher, $key, $options, $iv);
echo $data;
}
$message = "How are you doing?";
encrypt($message);
?>





<?php
// $iv = openssl_cipher_iv_length($cipher);
function encrypt($data){
$key = "klpqortbnwvxopliuytrv^\ty<}''%-()@.rcgqtpmqx";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));
$data = openssl_encrypt($data, "AES-256-CBC", $key, 0, $iv);
$data = base64_encode($iv.$data);
echo $data;
return $data;
}

function decrypt($data){
    $key = "klpqortbnwvxopliuytrv^\ty<}''%-()@.rcgqtpmqx";
    $data = base64_decode($data);
    $iv = substr($data, 0, openssl_cipher_iv_length("AES-256-CBC"));
    $data = substr($data, openssl_cipher_iv_length("AES-256-CBC"));
    $data = openssl_decrypt($data, "AES-256-CBC", $key, 0, $iv);
    echo $data;
}
$message = "How are you doing?";
$et = encrypt($message);
echo "<br>";
 decrypt($et);
?>


<?php
function str_encryptaesgcm($plaintext, $password, $encoding = null) {
    if ($plaintext != null && $password != null) {
        $keysalt = openssl_random_pseudo_bytes(16);
        $key = hash_pbkdf2("sha512", $password, $keysalt, 20000, 32, true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-gcm"));
        $tag = "";
        $encryptedstring = openssl_encrypt($plaintext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag, "", 16);
        return $encoding == "hex" ? bin2hex($keysalt.$iv.$encryptedstring.$tag) : ($encoding == "base64" ? base64_encode($keysalt.$iv.$encryptedstring.$tag) : $keysalt.$iv.$encryptedstring.$tag);
    }
}

function str_decryptaesgcm($encryptedstring, $password, $encoding = null) {
    if ($encryptedstring != null && $password != null) {
        $encryptedstring = $encoding == "hex" ? hex2bin($encryptedstring) : ($encoding == "base64" ? base64_decode($encryptedstring) : $encryptedstring);
        $keysalt = substr($encryptedstring, 0, 16);
        $key = hash_pbkdf2("sha512", $password, $keysalt, 20000, 32, true);
        $ivlength = openssl_cipher_iv_length("aes-256-gcm");
        $iv = substr($encryptedstring, 16, $ivlength);
        $tag = substr($encryptedstring, -16);
        return openssl_decrypt(substr($encryptedstring, 16 + $ivlength, -16), "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}


$enc = str_encryptaesgcm("How are you doing?", "myPassword", "base64"); // return a base64 encrypted string, you can also choose hex or null as encoding.
echo $enc;
echo "<br>";
$dec = str_decryptaesgcm($enc, "myPassword", "base64");
echo $dec;
?>



<?php
session_start();


 function encrypt_id($message){
 $secretKey = sodium_crypto_secretbox_keygen();
 $secretKeyHex = sodium_bin2hex($secretKey);
 $_SESSION['secretkeyhex'] = $secretKeyHex;
 $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
 $ciphertext = sodium_crypto_secretbox($message, $nonce, $secretKey);
 $result = sodium_bin2base64($nonce . $ciphertext, SODIUM_BASE64_VARIANT_ORIGINAL);
 $_SESSION['result'] = $result;
 sodium_memzero($message);
 sodium_memzero($nonce);
 sodium_memzero($secretKey);
 sodium_memzero($secretKeyHex);
 return $result;
 }

function decrypt_id($message){
  $secretKeyHex = $_SESSION['secretkeyhex'];
  $secretKey = sodium_hex2bin($secretKeyHex);
  $encrypted = $_SESSION['result'];
  $ciphertext = sodium_base642bin($encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
  $nonce = mb_substr($ciphertext, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
  $ciphertext = mb_substr($ciphertext, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
  $message = sodium_crypto_secretbox_open($ciphertext, $nonce, $secretKey);
  sodium_memzero($nonce);
  sodium_memzero($secretKey);
  sodium_memzero($secretKeyHex);
  sodium_memzero($ciphertext);
  return $message;
}
$message = 'Hello, this is a secret message!';
$et = encrypt_id($message);
echo $et;
echo "<br>";
$dt = decrypt_id($message);
echo $dt;
?>


<?php
require('connection.inc.php');


//  function encrypt_id($message, $con){
//  $secretKey = sodium_crypto_secretbox_keygen();
//  $secretKeyHex = sodium_bin2hex($secretKey);
//  $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
//  $ciphertext = sodium_crypto_secretbox($message, $nonce, $secretKey);
//  $result = sodium_bin2base64($nonce . $ciphertext, SODIUM_BASE64_VARIANT_ORIGINAL);
//  mysqli_query($con, "insert into sodium(encrypted_text, secretkey_hex) values('$result', '$secretKeyHex')");
//  sodium_memzero($message);
//  sodium_memzero($nonce);
//  sodium_memzero($secretKey);
//  sodium_memzero($secretKeyHex);
//  return $result;
//  }

function decrypt_id($con){
  $row = mysqli_fetch_assoc(mysqli_query($con, "select * from sodium where id = 6"));
  $secretKeyHex = $row['secretkey_hex'];
  $secretKey = sodium_hex2bin($secretKeyHex);
  $encrypted = $row['encrypted_text'];
  $ciphertext = sodium_base642bin($encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
  $nonce = mb_substr($ciphertext, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
  $ciphertext = mb_substr($ciphertext, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
  $message = sodium_crypto_secretbox_open($ciphertext, $nonce, $secretKey);
  sodium_memzero($nonce);
  sodium_memzero($secretKey);
  sodium_memzero($secretKeyHex);
  sodium_memzero($ciphertext);
  return $message;
}
// $message = 'Hello, this is a secret message!';
// $et = encrypt_id($message, $con);
// echo $et;
// echo "<br>";
$dt = decrypt_id($con);
echo $dt;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="check1.php" method="post">
        <input type="text" placeholder="Enter a title here!" name="title">
        <br><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
    $slug = $slug.'/'.substr(number_format(time() * rand(),0,'',''),0,6);
    echo $slug;
}
?>