<?php
function extractTextFromImages($folderPath, $outputFilePath) {
    $files = scandir($folderPath);
    $files = array_diff($files, array('.', '..'));
    $outputFile = fopen($outputFilePath, 'w');

    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $filePath)) {
            $command = "tesseract -l tur " . escapeshellarg($filePath) . " stdout";
            $text = shell_exec($command);
            fwrite($outputFile, $text . "\n");
        }
    }
    fclose($outputFile);
}

function convertPdfToImages($pdfPath, $outputDir) {
    if (!extension_loaded('imagick')) {
        echo 'Imagick Extension not installed. Please install Imagick Extension.';
        exit;
    }
    
    try {
        $imagick = new Imagick();
        $imagick->setResolution(200, 200);
        $imagick->readImage($pdfPath);
    
        foreach ($imagick as $index => $page) {
            $outputPath = $outputDir . 'page_' . ($index + 1) . '.png';
    
            $page->setImageFormat('png');
            $page->writeImage($outputPath);
        }
    
        echo 'PDF files converted to image.';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


function deleteFilesInFolder($folderPath) {
    $files = scandir($folderPath);

    $files = array_diff($files, array('.', '..'));

    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}

$pdfPath = './13.PDF';
$imagesPath = './images/';
$outputFilePath = './text/output.txt';

convertPdfToImages($pdfPath, $imagesPath);
extractTextFromImages($imagesPath, $outputFilePath);
deleteFilesInFolder($imagesPath);
?>
