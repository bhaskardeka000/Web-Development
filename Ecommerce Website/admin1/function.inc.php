<?php

function pr($arr){
echo '<pre>';
print_r($arr);
}

function prx($arr){
    echo '<pre>';
    print_r($arr);
    die();
}

function get_safe_value($con, $str){
    if($str!=''){
        $str = trim($str);
        return strip_tags(mysqli_real_escape_string($con, $str));
    }
}

function productSoldQtyByProductId($con, $pid){
    $sql = "select sum(order_details.qty) as qty from order_details, orders where orders.id = order_details.order_id and order_details.product_id = $pid and orders.order_status!=4 and ((orders.payment_type = 'payu' and orders.payment_status='success') or (orders.payment_type = 'cod' and orders.payment_status='success'))";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['qty'];
}

function encrypt_id($id){
    $encrypt_method = "AES-256-CBC";
    $secret_key = "HYUI-PLMO-CVYUP-QCRR-MGPL-DSK";
    $initialization_vector = "XJOQICRTPUZNLRSS";
    $key = hash('sha256', $secret_key);
    $initialization_vector = substr(hash('sha256', $initialization_vector), 0, 16);
    $id = openssl_encrypt($id, $encrypt_method, $key, 0, $initialization_vector);
    $id = base64_encode($id);
    return $id;
  }
  
  function decrypt_id($id){
    $encrypt_method = "AES-256-CBC";
    $secret_key = "HYUI-PLMO-CVYUP-QCRR-MGPL-DSK";
    $initialization_vector = "XJOQICRTPUZNLRSS";
    $id = base64_decode($id);
    $key = hash('sha256', $secret_key);
    $initialization_vector = substr(hash('sha256', $initialization_vector), 0, 16);
    $id = openssl_decrypt($id, $encrypt_method, $key, 0, $initialization_vector);
    return $id;
  }

  function zipWebsite($source, $destination, $flag = ''){
    if(!extension_loaded('zip') || !file_exists($source)){
      return false;
    }

    $zip = new ZipArchive();
    if(!$zip->open($destination, ZIPARCHIVE::CREATE)) {
      return false;
    }

    $source = str_replace('\\', '/', realpath($source));
    if($flag){
        $flag = basename($source) . '/';
    }

    if(is_dir($source) === true){
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file){

            $file = str_replace('\\', '/', realpath($file));

            if(strpos($flag.$file,$source) !== false) { // this will add only the folder we want to add in zip

                if(is_dir($file) === true){
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));

                }
                else if(is_file($file) === true){
                    $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
    }
    else if(is_file($source) === true){
        $zip->addFromString($flag.basename($source), file_get_contents($source));
    }
    return $zip->close();
}

function zipDatabase($source, $destination){
    if(!extension_loaded('zip') || !file_exists($source)){
      return false;
    }

    $zip = new ZipArchive();
    if(!$zip->open($destination, ZIPARCHIVE::CREATE)) {
       return false;
    }
    $zip->addFile($source, basename($source));
    return $zip->close();
}
?>