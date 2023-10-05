<?php
ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
set_time_limit(0);
include('google_drive/vendor/autoload.php');
include('mysqldump/vendor/autoload.php');
require('top.inc.php');

use Google\Client;
use Google\Service\Drive;
use Ifsnop\Mysqldump as IMysqldump;

if(isset($_POST['create_website_backup']) || isset($_POST['create_database_backup'])){
    if(!isset($_POST['backup_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['backup_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['backup_form']) || ($_POST['backup_form_token'] !== $_SESSION['csrf_token']['backup_form'])){
        ?>
        <script>
        alert("Error occured: Multiple tabs are open/token expired/invalid token.");
        window.location.href = "backup.php";
        </script>
        <?php
        die();
     }
}

if(isset($_POST['create_website_backup'])){

if(count(glob("backups/*SCI_Website.zip*")) > 0){
foreach(glob("backups/*SCI_Website.zip*") as $filename1){
    unlink($filename1);
}
}
// $otpt = "/home/u179486481/domains/scotchclubinternational.com/public_html/admin/SCI_Website.zip";
// $inpt = "/home/u179486481/domains/scotchclubinternational.com/public_html/";
$otpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/backups/SCI_Website.zip";
$inpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/";

if(zipWebsite($inpt,$otpt, true) !== false){
    try{
        $client = new Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=./google_drive/credentials.json');
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);
        
        $file1 = "backups/SCI_Website.zip";
        $unique_id = uniqid(mt_rand(), true);
        $unique_id = str_replace(".", "", $unique_id);
        $website_backup_file_name = "SCI_Website_".$unique_id.".zip";
        $mimeType = mime_content_type($file1);
        
        $fileMetadata = new Drive\DriveFile(
            array(
                
        'name' => $website_backup_file_name,
        'parents' => ['1osH4DWXFBwZ3LvxEt39O4gZNAIexuOT1']
        
        ));
        $content = file_get_contents($file1);
        $file1 = $driveService->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'resumable',
            'fields' => 'id'
        ));
        foreach(glob("backups/*SCI_Website.zip*") as $filename1){
            unlink($filename1);
        }
        unset($_SESSION['last_generated_token_time']['backup_form']);
        unset($_SESSION['csrf_token']['backup_form']);
        session_regenerate_id(true);
        $_SESSION['Message_success'] = 'Backup created and uploaded to google drive.'.'<br>'.'Backup Filename: '.$website_backup_file_name.'.'.'<br>'.'Tips: The backup file has been uploaded to the google drive associated with the google drive api email address.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
        }

        catch(Exception $e){
        foreach(glob("backups/*SCI_Website.zip*") as $filename1){
            unlink($filename1);
        }
        $_SESSION['Message_error'] = 'Error occured while uploading the backup. Please try again after sometime.';
        // unset($_SESSION['csrf_token']);
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
}
else{
    $_SESSION['Message_error'] = 'Error occured while archiving the backup. Please try again after sometime.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}
}

else if(isset($_POST['create_database_backup'])){
    
    if(count(glob("backups/*SCI_Database.*")) > 0){
        foreach(glob("backups/*SCI_Database.*") as $filename2){
            unlink($filename2);
        }
    }

    try {
        $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=ecommerce_database', 'root', '');
        // $fileNameDatabase = "SCI_Database".time().uniqid();
        $dump->start('backups/SCI_Database.sql');
        $otpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/backups/SCI_Database.zip";
        $inpt = "C:/xampp/htdocs/BhaskarProject/ecommerce website/admin1/backups/SCI_Database.sql";

        if(zipDatabase($inpt, $otpt) !== false){
            try{
                $client = new Client();
                putenv('GOOGLE_APPLICATION_CREDENTIALS=./google_drive/credentials.json');
                $client->useApplicationDefaultCredentials();
                $client->addScope(Drive::DRIVE);
                $driveService = new Drive($client);
                
                $file2 = "backups/SCI_Database.zip";
                $unique_id = uniqid(mt_rand(), true);
                $unique_id = str_replace(".", "", $unique_id);
                $database_backup_file_name = "SCI_Database_".$unique_id.".zip";
                $mimeType = mime_content_type($file2);
                
                $fileMetadata = new Drive\DriveFile(
                    array(
                        
                'name' => $database_backup_file_name,
                'parents' => ['1osH4DWXFBwZ3LvxEt39O4gZNAIexuOT1']
                
                ));
                $content = file_get_contents($file2);
                $file2 = $driveService->files->create($fileMetadata, array(
                    'data' => $content,
                    'mimeType' => $mimeType,
                    'uploadType' => 'resumable',
                    'fields' => 'id'
                ));
                foreach(glob("backups/*SCI_Database.*") as $filename2){
                    unlink($filename2);
                }

                unset($_SESSION['last_generated_token_time']['backup_form']);
                unset($_SESSION['csrf_token']['backup_form']);
                session_regenerate_id(true);
                $_SESSION['Message_success'] = 'Backup created and uploaded to google drive.'.'<br>'.'Backup Filename: '.$database_backup_file_name.'.'.'<br>'.'Tips: The backup file has been uploaded to the google drive associated with the google drive api email address.';
                ?>
                <script>
                window.location.href = window.location.href;
                </script>
                <?php
                die();
                }
        
                catch(Exception $e){
                foreach(glob("backups/*SCI_Database.*") as $filename2){
                    unlink($filename2);
                }
                $_SESSION['Message_error'] = 'Error occured while uploading the backup. Please try again after sometime.';  
                // unset($_SESSION['csrf_token']);
                ?>
                <script>
                window.location.href = window.location.href;
                </script>
                <?php
                die();
            }
        }
        else{
            foreach(glob("backups/*SCI_Database.*") as $filename2){
                unlink($filename2);
            }
            $_SESSION['Message_error'] = 'Error occured while archiving the backup. Please try again after sometime.';
            // unset($_SESSION['csrf_token']);
            ?>
            <script>
            window.location.href = window.location.href;
            </script>
            <?php
            die();
        }
    }
    catch(Exception $e){
        $_SESSION['Message_error'] = 'Error occured while creating the database backup. Please try again after sometime.';  
        // unset($_SESSION['csrf_token']);
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['backup_form'])){
    $backup_form_generated_token = bin2hex(random_bytes(16));
    $_SESSION['csrf_token']['backup_form'] = $backup_form_generated_token;
    $_SESSION['last_generated_token_time']['backup_form'] = time();
  }
  else{
    $interval = 60 * 25;
    if(time() -  $_SESSION['last_generated_token_time']['backup_form']>= $interval){
        $backup_form_generated_token = bin2hex(random_bytes(16));
        $_SESSION['csrf_token']['backup_form'] = $backup_form_generated_token;
        $_SESSION['last_generated_token_time']['backup_form'] = time();
    }
    else{
        $backup_form_generated_token = $_SESSION['csrf_token']['backup_form'];
    }
  }
?>

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Backup Data</h3>
        </div>
        <!-- <div class="row"></div> -->
        <div class="card mb-0 backup_card_mb_div">        
            <div class="card-body">
            <?php
                  if(isset($_SESSION['Message_error'])){
                  ?>
                  <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['Message_error'] ?>
                  </div>
                  <?php
                  unset($_SESSION['Message_error']);
                  }

                  else if(isset($_SESSION['Message_success'])){
                    ?>
                    <div class="alert alert-success" role="alert">
                          <?php echo $_SESSION['Message_success'] ?>
                    </div>
                    <?php
                    unset($_SESSION['Message_success']);
                    }
               ?>
                <form method="post">
                    <input type="hidden" name="backup_form_token" value="<?php echo $backup_form_generated_token ?>">
                    <p class="create_and_upload_backup_p_tag">1. Create and upload website backup to google drive:</p>
                    <button type="submit" name="create_website_backup" id="website_backup_btn"><span>CREATE AND UPLOAD</span></button>
                    <hr>
                    <p class="create_and_upload_backup_p_tag">2. Create and upload database backup to google drive:</p>
                    <button type="submit" name="create_database_backup" id="database_backup_btn"><span>CREATE AND UPLOAD</span></button>
                </form>
            </div>
        </div>

        <div class="card mb-0">
          <div class="card-body">
              <p class="create_and_upload_backup_p_tag">Important:</p>
              <p class="create_and_upload_backup_p_tag">Website backup can be created by the following three methods:</p>
              <p class="create_and_upload_backup_p_tag">1. By clicking Button 1 to create website backup.</p>
              <p class="create_and_upload_backup_p_tag">2. By logging into hostinger account > Websites > Manage > Daily backups manage > Files backups.</p>
              <p class="create_and_upload_backup_p_tag">3. By accessing the file manager of the website and then downloading the 'public_html' folder (ZIP format is recommended to download).</p>
              <br>
              <p class="create_and_upload_backup_p_tag">Database backup can be created by the following three methods:</p>
              <p class="create_and_upload_backup_p_tag">1. By clicking Button 2 to create database backup.</p>
              <p class="create_and_upload_backup_p_tag">2. By logging into hostinger account > Websites > Manage > Daily backups manage > Database backups.</p>
              <p class="create_and_upload_backup_p_tag">3. By accessing the databases of the website i.e accessing PHPMyAdmin > Export > Quick - display only the minimal options > Go.</p>
              <br>
              <p class="create_and_upload_backup_p_tag">Note:</p>
              <p class="create_and_upload_backup_p_tag">1. If Button 1 or Button 2 is clicked, the website and database backup will be created and uploaded/stored in google drive.</p>
              <p class="create_and_upload_backup_p_tag">2. Sometime errors may occur while choosing method 1 i.e clicking Button 1 or Button 2. In that case, you can reload the page or try another methods.</p>
          </div>
        </div>
    </div>

<?php require('footer.inc.php'); ?>