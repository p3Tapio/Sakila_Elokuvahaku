<?php
if(isset($_POST["submit"])) {
    $nimi = strip_tags($_POST["nimi"]);
    $kuvaus = strip_tags($_POST["kuvaus"]);
    $vuosi = (int)$_POST["julkaisuvuosi"];
    $aika = (int)$_POST["vuokra-aika"];
    $hinta = (float)$_POST["vuokrahinta"];
    $pituus = (int)$_POST["pituus"]; 
    $korvaus = (float)$_POST["korvaushinta"]; 
    $kieli = (int)$_POST["kielet"];
    $ika = strip_tags($_POST["ikaraja"]);
    $features=$_POST['specialfeatures'];
    print_r($features);     

}


?>
