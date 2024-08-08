<?php
require 'vendor/autoload.php';

// Load the XML file
$xmlFile = './output.xml';
$xml = simplexml_load_file($xmlFile);

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

// Read XML lines and write them to the Excel sheet
$row = 1;
foreach ($xml->line as $line) {
    $col = 0;
    $sheet->setCellValueByColumnAndRow($col, $row, (string)$line);
    $row++;
}

// Save the Excel file
$excelFile = './output.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($excelFile);

echo "Excel file has been created successfully at: $excelFile";
?>