<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

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

function convertTxtFilesToXml($inputFolder, $outputFolder) {
    $txtFiles = glob("$inputFolder/*.txt");
    
    $charMap = array(
        'İ' => 'I',
        'ı' => 'i',
        'Ğ' => 'G',
        'ğ' => 'g',
        'Ü' => 'U',
        'ü' => 'u',
        'Ş' => 'S',
        'ş' => 's',
        'Ö' => 'O',
        'ö' => 'o',
        'Ç' => 'C',
        'ç' => 'c',
        '?' => '',     
        ':' => '',
        '^L' => ''
    );

    foreach ($txtFiles as $txtFile) {
        $filename = pathinfo($txtFile, PATHINFO_FILENAME);
        
        $txtData = file($txtFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($txtData === false) {
            die("TXT dosyası okunamadı: $txtFile");
        }

        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xmlContent .= "<data_$filename>" . PHP_EOL;

        foreach ($txtData as $line) {
            $convertedLine = strtr(trim($line), $charMap);
            $xmlContent .= '    <line>' . htmlspecialchars($convertedLine) . '</line>' . PHP_EOL;
        }

        $xmlContent .= "</data_$filename>" . PHP_EOL;

        $outputFile = "$outputFolder/$filename.xml";
        file_put_contents($outputFile, $xmlContent);
        echo "TXT dosyası başarıyla dönüştürüldü: $txtFile -> $outputFile\n";
    }
}

function processAllPdfs($pdfFolder, $textFolder, $xmlFolder) {
    $pdfFiles = glob("$pdfFolder/*.pdf");

    foreach ($pdfFiles as $pdfFile) {
        $outputFilePath = $textFolder . '/' . pathinfo($pdfFile, PATHINFO_FILENAME) . '.txt';
        extractTextFromPdf($pdfFile, $outputFilePath);
    }

    convertTxtFilesToXml($textFolder, $xmlFolder);
    // xmlToExcel($xmlFolder);
}

function xmlToExcel($xmlFolder){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $col = 1;
    $row = 1;

    $files = glob("$xmlFolder/*.xml");

    foreach ($files as $xmlFile) {
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->line as $line) {
            $column = Coordinate::stringFromColumnIndex($col - 1);
            $sheet->setCellValue($column . $row, (string)$line);
            $col++;
        }
        $row++;
        $col = 1;

        $excelFile = './output.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFile);

        echo "Excel file generated successfully for $xmlFile\n";
    }
}

$pdfFolder = './pdf';
$textFolder = './text';
$xmlFolder = './xml';

processAllPdfs($pdfFolder, $textFolder, $xmlFolder);
// xmlToExcel($xmlFolder);
// deleteFiles($textFolder);
// deleteFiles($xmlFolder);
?>