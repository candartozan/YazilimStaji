<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

$parser = new Parser();
$pdf = $parser->parseFile('./13.pdf');
$text = $pdf->getText();
$lines = explode("\n", $text);

$xml = new SimpleXMLElement('<data/>');

// Veriyi parse edip XML yapısına ekleyelim
foreach ($lines as $line) {
    // Burada PDF'deki veriyi uygun bir şekilde parse etmeniz gerekecek
    // Örneğin, "Vergi Dairesi : Kizilbey" gibi satırları parçalayarak XML'e ekleyebiliriz
    if (strpos($line, ':') !== false) {
        list($field, $value) = explode(':', $line, 2);
        $row = $xml->addChild('row');
        $row->addChild('col3', trim($field));
        $row->addChild('col4', ':');
        $row->addChild('col5', trim($value));
    }
    // Diğer durumları da uygun şekilde işleyebilirsiniz
}

// XML'i dosyaya kaydetme
$xml->asXML('./converted_data.xml');

echo "PDF'den XML'e dönüştürme işlemi tamamlandı.";
?>