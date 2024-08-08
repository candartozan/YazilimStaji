<?php
// PHP dosyasının başlangıcında UTF-8 kullanımı için gerekli ayarları yapın
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');

require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

$parser = new Parser();
$pdf = $parser->parseFile('./13.pdf');
$text = $pdf->getText();
$text = mb_convert_encoding($text, 'UTF-8', 'auto'); // Metni UTF-8'e dönüştür

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
$xml->asXML('./output.xml');

echo "PDF'den XML'e dönüştürme işlemi tamamlandı.";
?>