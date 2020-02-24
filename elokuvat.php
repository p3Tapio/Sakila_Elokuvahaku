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
        <table class="table table-hover">
                 <thead> 
                    <tr class="table-primary"><td>Nimi</td><td>Kuvaus</td><td>Ikäraja</td><td>Julkaisuvuosi</td></tr>
                    </thead>
                 <tbody>
                    <?php
                        if (isset($_POST["submit"]) && $_POST["haku"]!="") { 
                            $haku = "%".strip_tags($_POST["haku"])."%";
                            $sql = "SELECT * FROM film WHERE title LIKE '$haku'";
                            createTable($sql);     
                        }      
                    ?>
                </tbody>
        </table>
    </div>

<?php
    function createTable($sqlQuery) {

        $yhteys = new mysqli("localhost", "root", "", "sakila") or die("yhteyden muodostus epäonnistui");;
        $yhteys->set_charset("utf8");
        $tulokset = $yhteys->query($sqlQuery); 


        if (isset($_POST["submit"])) { 
    

            $taulu = "<tr>"; 

             if($tulokset->num_rows) {
                echo "<h4>Hakutuloksia ".$tulokset->num_rows." kpl.</h4>"; 

                while($rivi = $tulokset->fetch_assoc()) { 
                    $taulu .= "<td>".$rivi["title"]."</td><td>".$rivi["description"]."</td><td>".$rivi["rating"]."</td><td>".$rivi["release_year"]."</tr>";        
                 }   
                echo $taulu;
             } else {
                  echo "<h4><strong>Ei hakutuloksia.</strong></h4>";
            
            }
        }


    }



?>
</body>
</html>