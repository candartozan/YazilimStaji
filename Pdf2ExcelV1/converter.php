<?php
function deleteFiles($directory) {
    if (!is_dir($directory)) {
        die("Belirtilen dizin bulunamadı: $directory");
    }

    $files = glob($directory . '/*');

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "Dosya silindi: $file\n";
        }
    }
}

function extractTextFromPdf($pdfPath, $outputFilePath) {
    $command = "pdftotext " . escapeshellarg($pdfPath) . " " . escapeshellarg($outputFilePath);
    $sedCommand = "awk '/^\\014/{sub(\"\\014\",\"\")}1' " . escapeshellarg($outputFilePath) . " > " . escapeshellarg($outputFilePath . ".tmp") . " && mv " . escapeshellarg($outputFilePath . ".tmp") . " " . escapeshellarg($outputFilePath);
    shell_exec($command);
    shell_exec($sedCommand);

    if (file_exists($outputFilePath)) {
        $text = file_get_contents($outputFilePath);
        return $text;
    } else {
        return false;
    }
}


function processAllPdfs($pdfFolder, $textFolder) {
    $pdfFiles = glob("$pdfFolder/*.pdf");

    foreach ($pdfFiles as $pdfFile) {
        $outputFilePath = $textFolder . '/' . pathinfo($pdfFile, PATHINFO_FILENAME) . '.txt';
        extractTextFromPdf($pdfFile, $outputFilePath);
    }
}


$pdfFolder = './pdf';
$textFolder = './text';

processAllPdfs($pdfFolder, $textFolder);
// xmlToExcel($xmlFolder);
// deleteFiles($textFolder);
// deleteFiles($xmlFolder);
?>