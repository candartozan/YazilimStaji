<?php
function extractTextFromPdf($pdfPath, $outputFilePath) {
    $command = "pdftotext " . escapeshellarg($pdfPath) . " " . escapeshellarg($outputFilePath);
    $result = shell_exec($command);

    if (file_exists($outputFilePath)) {
        $text = file_get_contents($outputFilePath);
        return $text;
    } else {
        return false;
    }
}

function textToXml($text, $xmlFilePath) {
    $xml = new SimpleXMLElement('<root/>');
    $xml->addChild('content', htmlspecialchars($text));
    $xml->asXML($xmlFilePath);
}

$pdfPath = './13.pdf';
$outputFilePath = './output.txt';
$xmlFilePath = './output.xml';

$text = extractTextFromPdf($pdfPath, $outputFilePath);

if ($text !== false) {
    textToXml($text, $xmlFilePath);
    echo "Metin başarıyla XML dosyasına aktarıldı: $xmlFilePath";
} else {
    echo "Metin çıkarılamadı.";
}
?>