<?php
// ini_set('max_execution_time', -1); //300 seconds = 5 minutes
// ini_set('memory_limit', '-1');

ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
set_time_limit(0);

function zipFile($source, $destination, $flag = '')
{
    if (!extension_loaded('zip') || !file_exists($source)) {
      return false;
    }
    

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
      return false;
    }

    $source = str_replace('\\', '/', realpath($source));
    if($flag)
    {
        $flag = basename($source) . '/';
    }

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {

            $file = str_replace('\\', '/', realpath($file));

            if (strpos($flag.$file,$source) !== false) { // this will add only the folder we want to add in zip

                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));

                }
                else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString($flag.basename($source), file_get_contents($source));
    }

    return $zip->close();
}
// $s1 = dirname(__DIR__, 1); 
// // $s2 = "/public_html/";
// $rootPath = $s1;

// if(file_exists('SCI_Website.zip')){
//     unlink('SCI_Website.zip');
// }
if(count(glob("*SCI_Website.zip*")) > 0){
foreach (glob("*SCI_Website.zip*") as $filename) {
    unlink($filename);
}
}

// $otpt = "/home/u179486481/domains/scotchclubinternational.com/public_html/admin/SCI_Website.zip";
// $inpt = "/home/u179486481/domains/scotchclubinternational.com/public_html/";
$otpt = "C:/xampp/htdocs/BhaskarProject/ecommerce%20website/admin1/SCI_Website.zip";
$inpt = "C:/xampp/htdocs/BhaskarProject/ecommerce%20website/admin1/";
// zipFile($inpt,$otpt, true); //Call to function
if(zipFile($inpt,$otpt, true)!=false){
echo "Zip/backup generated.";
echo "<br>";
}
else{
    echo "Error occured";
}

require_once('google_drive/vendor/autoload.php');
use Google\Client;
use Google\Service\Drive;
# TODO - PHP client currently chokes on fetching start page token
function uploadBasic()
{
    try {
        $client = new Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=./google_drive/credentials.json');
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);
        
        $file = getcwd().'/SCI_Website.zip';
        $fileName = "SCI_Backup_".time().uniqid().".zip";
        $mimeType = mime_content_type($file);
        
        $fileMetadata = new Drive\DriveFile(
            array(
                
        'name' => $fileName,
        'parents' => ['1osH4DWXFBwZ3LvxEt39O4gZNAIexuOT1']
        
        ));
        $content = file_get_contents($file);
        $file = $driveService->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'resumable',
            'fields' => 'id'
        ));
        // printf("File ID: %s\n", $file->id);
        echo "Backup file has been uploaded to google drive successfuly.";
        echo "Backup File Name: ".$fileName;
        echo "Sent to google drive account associated with Email ID: ";
        // echo $service->about->get()->getUser()->getemailAddress();
        // echo $service->people->get("people/me");
        return $file->id;
    } catch(Exception $e) {
        echo "Error Message: ".$e;
    } 

}

uploadBasic();
echo "Zip/backup uploaded to google drive.";
?>