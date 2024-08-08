<?php
class SimpleXMLExtended extends SimpleXMLElement {
    public function addCData($cdata_text) {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }
}

function extractTextFromPdf($pdfPath) {
    $outputFilePath = tempnam(sys_get_temp_dir(), 'pdftotext');
    $command = "pdftotext -enc UTF-8 " . escapeshellarg($pdfPath) . " " . escapeshellarg($outputFilePath);
    shell_exec($command);

    if (file_exists($outputFilePath)) {
        $text = file_get_contents($outputFilePath);
        unlink($outputFilePath); // Geçici dosyayı sil
        return $text;
    } else {
        return false;
    }
}

function textToXml($text, $xmlFilePath) {
    $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><root/>');
    $content = $xml->addChild('content');
    $content->addCData($text); // Metni CDATA bloğu içinde sakla
    $xml->asXML($xmlFilePath);
}

$pdfPath = './13.pdf'; // PDF dosyasının yolu
$xmlFilePath = './output.xml'; // XML dosyasının yolu

$text = extractTextFromPdf($pdfPath);

if ($text !== false) {
    textToXml($text, $xmlFilePath);
    echo "Metin başarıyla XML dosyasına aktarıldı: $xmlFilePath";
} else {
    echo "Metin çıkarılamadı.";
}
?>