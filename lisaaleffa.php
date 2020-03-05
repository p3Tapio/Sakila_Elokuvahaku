<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <script src="navscript.jsx" type="text/babel"></script>
   
</head>
<body>
<div id = "nav"></div>

<div class="container" style="margin-top: 25px;">
    <div class="row">
        <form class="col-sm-4" method="post">
            <legend>Lisää elokuva tietokantaan</legend>
            <fieldset>
                <div class="form-group">
                        <input type="text" name="nimi" class="form-control-lg" placeholder="Nimi"><br>
                        <input type="text" name="kuvaus" class="form-control-lg" placeholder="Kuvaus"><br>
                        <input type="text" name="julkaisuvuosi" class="form-control-lg" placeholder="Julkaisuvuosi"><br>
                        <div class="form-group">
                        <select class="form-control-lg" name = "kielet" style ="width: 240px;">
                            <?php getKielet(); ?>
                        </select><br>
                        <input type="text" name="vuokra-aika" class="form-control-lg" placeholder="Vuokra-aika"><br>
                        <input type="text" name="vuokrahinta" class="form-control-lg" placeholder="Vuokrahinta"><br>
                        <input type="text" name="pituus" class="form-control-lg" placeholder="Pituus"><br>
                        <input type="text" name="korvaushinta" class="form-control-lg" placeholder="Korvaushinta"><br>
                        <select class="form-control-lg" name = "ikaraja" style ="width: 240px;">
                            <?php ikarajat(); ?>
                        </select><br>
                        <select class="form-control" name="specialfeatures[]" style="width: 240px" multiple>
                            <option value="Deleted Scenes">Deleted Scenes</option>
                            <option value="Behind the Scenes">Behind the Scenes</option>
                            <option value="Commentaries">Commentaries</option>
                            <option value="Trailers">Trailers</option>
                        </select>
                        <input  type="submit" name="submit" class="btn btn-outline-primary btn-lg" value="Tallenna" style="margin-top: 5px"/> 
                        <input type="reset" name="reset" class="btn btn-outline-danger btn-lg" value="Tyhjennä" style="margin-top: 5px"/>
                </div>
            </fieldset>
        </form>
    </div>
<hr>  
</div>


<?php 

    function getKielet() {
        $yhteys = connect(); 
        $query = "SELECT * FROM language";
        $kielet = $yhteys->query($query); 
        $selectList = "<option selected=\"kieli\">Kieli</option>";
        while($rivi = $kielet->fetch_assoc()) { 
            $selectList.="<option value=\"".$rivi["language_id"]."\">".$rivi["name"]."</option>";
        }
        mysqli_close($yhteys);
        echo $selectList;            
    }
    function ikarajat() {
        $yhteys = connect(); 
        $query = 'SELECT DISTINCT rating FROM film ORDER BY rating ASC';
        $ika = $yhteys->query($query);
        $ratingList = "<option selected=\"ikaraja\">Ikäraja</option>";
        while($rivi = $ika->fetch_assoc()) { 
            $ratingList.="<option value=\"".$rivi["rating"]."\">".$rivi["rating"]."</option>";
        }
        mysqli_close($yhteys);
        echo $ratingList;  

    }
    function connect() {
        $yhteys = new mysqli("127.0.0.1:51034", "azure", "6#vWHD_$", "sakila") or die("yhteyden muodostus epäonnistui");
        // $yhteys = new mysqli("localhost", "root", "", "sakila") or die("yhteyden muodostus epäonnistui");
        $yhteys->set_charset("utf8");
        return $yhteys; 
    }


    if(isset($_POST["submit"])) {
       if(isset($_POST["kuvaus"])&& isset($_POST["julkaisuvuosi"])&& isset($_POST["vuokra-aika"]) && isset($_POST["vuokrahinta"])&& isset($_POST["pituus"])&& isset($_POST["korvaushinta"])&& isset($_POST["kielet"])&& isset($_POST["ikaraja"])&& isset($_POST["specialfeatures"])) {
            $nimi = strip_tags($_POST["nimi"]);
            $kuvaus = strip_tags($_POST["kuvaus"]);
            $vuosi = (int)$_POST["julkaisuvuosi"];
            $aika = (int)$_POST["vuokra-aika"];
            $hinta = (float)$_POST["vuokrahinta"];
            $pituus = (int)$_POST["pituus"]; 
            $korvaus = (float)$_POST["korvaushinta"]; 
            $kieli = (int)$_POST["kielet"];
            $ika = strip_tags($_POST["ikaraja"]);
            $features=(array)$_POST['specialfeatures'];
            $feats = implode(",", $features);
            echo $feats; 
        } else {
            echo "Täytä kaikki kentät!"; 
        }
        $yhteys = connect(); 
        // \'original_language_id\',
        $q = "INSERT INTO film  (title,description,release_year,language_id, rental_duration,rental_rate,length,replacement_cost,rating,special_features)
        VALUES ('$nimi','$kuvaus','$vuosi', '$kieli','$aika','$hinta','$pituus', '$korvaus', '$ika', '$feats')";

     
        if($yhteys->query($q)) {
            echo "jes!"; 
        } else {
            echo "Nope! ".$yhteys->error; 
        }


    }

?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>