<?php
    // TODO: if(leffakannassa) { }
    // Rating ja original language puuttuu -->  $ika = strip_tags($_POST["ikaraja"]);
    // tallennuksessa , -> . välimerkkimuunnos tai tarkistus 


    if(isset($_GET['call'])) {
        switch($_GET['call']) {
            case 'all':
                getAllFilms();
                break;
            case 'name':
                getFilmsByName(); 
                break; 
            case 'genres':
                getGenres(); 
                break; 
            case 'getgenre':
                getFilmsByGenre();
                break;
            case 'kielet': 
                getKielet(); 
                break; 
            case 'setfilm':
                setFilm(); 
                break; 
            default:
                http_response_code(404); 
            } 
        } else {
            http_response_code(404); 
        }

// -------------------------------------------------------------
    function getAllFilms() {

        $yhteys = connect(); 
        if(isset($_GET['start']) && isset($_GET['start']) ) {
            $start = (int)$_GET['start'];
            $end = (int)$_GET['end'];
            $q = "SELECT * from film INNER JOIN language on film.language_id = language.language_id LIMIT ".$start.",".$end; 
        } else {
            $q = "SELECT * from film INNER JOIN language on film.language_id = language.language_id";
        }
        $tulokset = $yhteys->query($q); 
        createJson($tulokset, $yhteys);

    }
    function getFilmsByName() {
            
        if(isset($_GET['name'])) {
            $yhteys = connect();
            $haku = "%".strip_tags($_GET["name"])."%";
            $q = "SELECT * FROM film WHERE title LIKE '$haku'";
            $tulokset = $yhteys->query($q); 
            createJson($tulokset, $yhteys);
        }
    }
    function getGenres() {
        $yhteys = connect();
        $q= "select name from category";
        $tulokset = $yhteys->query($q); 
        createJson($tulokset, $yhteys);
    }   
    function getFilmsByGenre() {
         
        if(isset($_GET['genre'])) {
            $yhteys = connect();
            $haku = "\"".strip_tags($_GET['genre'])."\"";
            $q = "SELECT * FROM film f INNER JOIN film_category fa on f.film_id = fa.film_id INNER JOIN category c ON c.category_id = fa.category_id where c.name = ".$haku;  
            $tulokset = $yhteys->query($q); 
            createJson($tulokset, $yhteys);
        }
    }
    function getKielet() {
        $yhteys = connect(); 
        $q= "SELECT * FROM language";
        $tulokset = $yhteys->query($q); 
        createJson($tulokset, $yhteys);         
    }      
    function setFilm() {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $resposeMsg ="";
        if(isset($_POST["kuvaus"])&& isset($_POST["vuosi"])&& isset($_POST["aika"]) && isset($_POST["vuokrahinta"])&& isset($_POST["pituus"])&& isset($_POST["korvaushinta"])&& isset($_POST["kieli"])&& isset($_POST["features"])) {
            $nimi = strip_tags($_POST["nimi"]);
            $kuvaus = strip_tags($_POST["kuvaus"]);
            $vuosi = (int)$_POST["vuosi"];
            $aika = (int)$_POST["aika"];
            $hinta = (float)$_POST["vuokrahinta"];
            $pituus = (int)$_POST["pituus"]; 
            $korvaus = (float)$_POST["korvaushinta"]; 
            $kieli = (int)$_POST["kieli"];
    
            $features=(array)$_POST['features'];
            $feats = implode(",", $features);
            $resposeMsg = "muuttujiin siirto ok"; 
        } else {
            $resposeMsg = "Täytä kaikki kentät"; 
        }  
        $yhteys = connect(); 
        // if kannassa niin $resposeMsg = "ON JO!"; 
        $q = "INSERT INTO film  (title,description,release_year,language_id, rental_duration,rental_rate,length,replacement_cost,special_features)
        VALUES ('$nimi','$kuvaus','$vuosi', '$kieli','$aika','$hinta','$pituus', '$korvaus', '$feats')";

        if($yhteys->query($q)) {
            $resposeMsg ="Tallennus ok";
        } else {
            $resposeMsg = "Tallennus epäonnistui ".$yhteys->error;  
        }

        echo $resposeMsg; 
        mysqli_close($yhteys);
 
    } 
    function createJson($toJson, $yhteys) {

        if($toJson && $yhteys) {
            echo '[';
            for($i = 0; $i < mysqli_num_rows($toJson); $i++) {
                echo ($i>0?',':'').json_encode(mysqli_fetch_object($toJson)); 
            }
            echo ']';
        } else {
            http_response_code(404); 
            die(mysqli_error($yhteys));
        }  
        mysqli_close($yhteys);
    }
    function connect() {
        $yhteys = new mysqli("localhost", "root", "", "sakila") or die("Connection fail ".mysqli_connect_error());
        $yhteys->set_charset("utf8");
        return $yhteys;
    }
?>
