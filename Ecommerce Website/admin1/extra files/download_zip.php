<?php
$zipFilename = "ADMIN1.zip";
// $rootPath = "../admin1/";
// $rootPath = realpath('admin1');
// echo getcwd();
$rootPath = getcwd();
// Initialize archive object
$zip = new ZipArchive();
$zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file)
{
    // Get real and relative path for current file
    $filePath = $file->getRealPath();
    $relativePath = substr($filePath, strlen($rootPath) + 1);

    if (!$file->isDir())
    {
        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }else {
        if($relativePath !== false)
            $zip->addEmptyDir($relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
?>

<a href="<?php echo $zipFilename ?>" download>Download ZIP</a>

