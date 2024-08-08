<?php
function saveToDatabase($txtFile) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ASKI";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı başarısız: " . $conn->connect_error);
    }
    echo "Bağlantı başarılı<br>";

    $conn->set_charset("utf8");
    $text = file($txtFile);
    $text = $conn->real_escape_string($text);
    $sql = "INSERT INTO tif (pdf_to_text) VALUES ('$text')";

    $conn->close();
}
?>


