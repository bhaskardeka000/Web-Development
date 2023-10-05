<?php
include('mysqldump/vendor/autoload.php');
require('top.inc.php');
use Ifsnop\Mysqldump as IMysqldump;

if(count(glob("backup/*SCI_Database.*")) > 0){
    foreach (glob("backup/*SCI_Database.*") as $filename2) {
        unlink($filename2);
    }
}

try {
    $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=ecommerce_database', 'root', '');
    // $fileNameDatabase = "SCI_Database".time().uniqid();
    $dump->start('backup/SCI_Database.sql');
    $msg = "sql_created";
} catch (\Exception $e) {
    echo 'mysqldump-php error: ' . $e->getMessage();
}

if($msg=='sql_created'){


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


    $otpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/backup/SCI_Database.zip";
    $inpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/backup/SCI_Database.sql";
    if(zipDatabase($inpt,$otpt, true) !== false){
        echo "Zip of database created successfully!";
    }
    else{
        echo "Error creating database zip!";
    }
}

?>