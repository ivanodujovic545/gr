<html>
<head>
<title>Račun</title>

<style>
body {
    background-color: #f9f9f9;
    font-family: Arial;
}

.racun {
    width: 350px;
    border: 2px solid black;
    padding: 20px;
    background-color: white;
}

img {
    width: 150px;
    opacity: 0.5;
    transition: 0.3s;
}

img:hover {
    opacity: 1;
    transform: scale(1.2);
    box-shadow: 5px 5px 10px gray;
}
</style>

</head>
<body>

<h1>Online ljekarna</h1>
<h3>Ljekarna narudžba</h3>

<div class="racun">

<?php

define("ANDOL", 3.75);
define("ASPIRIN", 5.20);
define("VITAMINC", 7.50);


$andol = $_POST['andol'];
$aspirin = $_POST['aspirin'];
$vitaminc = $_POST['vitaminc'];
$izvor = $_POST['izvor'];
$kartica = $_POST['kartica'];
$placanje = $_POST['placanje'];


if (!preg_match("/^[0-9]{9,11}$/", $kartica)) {
    echo "<p style='color:red;'>Greška: kartica mora imati 9-11 znamenki!</p>";
    exit();
}


$file = "kartice.txt";


if (!file_exists($file)) {
    file_put_contents($file, "");
}

$kartice = file($file, FILE_IGNORE_NEW_LINES);

if (in_array($kartica, $kartice)) {
    $kupac = "da";
    echo "<p>Dobrodošli nazad! (redovan kupac)</p>";
} else {
    $kupac = "ne";
    echo "<p>Prva narudžba - registracija uspješna!</p>";
    
  
    file_put_contents($file, $kartica . PHP_EOL, FILE_APPEND);
}


echo "<br>Datum: " . date("d.m.Y") . "<br><br>";


echo "Andol: $andol kom<br>";
echo "Aspirin: $aspirin kom<br>";
echo "Vitamin C: $vitaminc kom<br><br>";


$osnovica = ($andol * ANDOL) + ($aspirin * ASPIRIN) + ($vitaminc * VITAMINC);


if ($placanje == "direktno") {
    $osnovica *= 0.95;
    echo "Popust 5% primijenjen<br>";
}


$pdv = $osnovica * 0.25;
$ukupno = $osnovica + $pdv;


echo "<br>Osnovica: " . number_format($osnovica, 2) . " €<br>";
echo "PDV: " . number_format($pdv, 2) . " €<br>";
echo "<b>Ukupno: " . number_format($ukupno, 2) . " €</b><br><br>";

echo "Izvor: $izvor<br>";
echo "Način plaćanja: $placanje<br><br>";

if ($ukupno > 30 && $kupac == "da") {
    echo "<p>Dobili ste iznenađenje kao vjerni kupac!</p>";
    echo "<img src='https://via.placeholder.com/150'>";
}

if ($kupac == "da") {
    echo "<p><b>Hvala na Vašoj narudžbi!</b></p>";
} else {
    echo "<p><b>Hvala. Dođite nam opet!</b></p>";
}

?>

</div>

</body>
</html>
