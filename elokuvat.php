<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container" style="margin-top: 25px;">
        <div class="row">
            <form class="col-sm-4" method="post">
                <legend>Hae elokuvia</legend>
                <fieldset>
                    <div class="form-group">
                            <input type="text" name="haku" class="form-control-lg" id="staticEmail" placeholder="Hakukenttä"><br>
                            <input type="submit" name="submit" class="btn btn-outline-primary btn-lg" value="hae" style="margin-top: 5px"/> 
                    </div>
                </fieldset>
            </form>
        </div>
                
    <?php
    if (isset($_POST["submit"]) && $_POST["haku"]!="") { 
        $haku = "%".strip_tags($_POST["haku"])."%";
        $sql = "SELECT * FROM film WHERE title LIKE '$haku'";
        createCards($sql);     
    }      

    function createCards($sqlQuery) {

        $yhteys = new mysqli("localhost", "root", "", "sakila") or die("yhteyden muodostus epäonnistui");;
        $yhteys->set_charset("utf8");
        $tulokset = $yhteys->query($sqlQuery); 

        if (isset($_POST["submit"])) { 
             if($tulokset->num_rows) {
                echo "<h4>Hakutuloksia ".$tulokset->num_rows." kpl.</h4><br>"; 
                $kortti ="<div class = \"row\">";
                while($rivi = $tulokset->fetch_assoc()) { 
                    $kortti .= "<div class=\"card border-primary mb-3\" style=\"max-width: 20rem; margin: 5px;\">"; 
                    $kortti .= "<div class=\"card-header\">".$rivi["release_year"]." (".$rivi["rating"].")</div>";
                    $kortti .= "<div class=\"card-body\">";
                    $kortti .= "<h4 class=\"card-title\">".$rivi["title"]."</h4>";
                    $kortti .= "<p class=\"card-text\">".$rivi["description"]."</p></div></div>";
                    
                 }   
                 echo $kortti."</div>";
             } else {
                  echo "<h4>Ei hakutuloksia.</h4>";
            
            }
        }
    }
?>
</body>
</html>