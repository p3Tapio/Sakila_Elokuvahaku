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
        <form class="col-sm-12" method="post">
            <legend>Hae elokuvia</legend>
            <fieldset>
                <div class="form-group">
                <?php  createButtons();  ?>
                </div>
            </fieldset>
        </form>
    </div>
<hr>      
    <?php
        getCards(); 
    ?>
</div>
<?php       
        function createButtons() {
            $yhteys = connect(); 
            $sqlQuery = "select * from category";
            $tulokset = $yhteys->query($sqlQuery); 
            while($rivi = $tulokset->fetch_assoc()) { 
               echo "<input type=\"submit\" name=\"".$rivi['name']."\" class=\"btn btn-outline-primary btn-sm\" value=\"".$rivi['name']."\" style=\"margin-top: 5px\"/>\n";  
            }
            mysqli_close($yhteys);
        }
       function connect() {
            //$yhteys = new mysqli("127.0.0.1:51034", "azure", "6#vWHD_$", "sakila") or die("yhteyden muodostus epäonnistui");
            $yhteys = new mysqli("localhost", "root", "", "sakila") or die("yhteyden muodostus epäonnistui");
            $yhteys->set_charset("utf8");
            return $yhteys; 
        }

        function getCards() {

            $q = generateQuery(); 
            $yhteys = connect(); 

            if(strlen($q)>0) {

                $leffat = $yhteys->query($q);
                if($leffat->num_rows) {
                    echo "<h4>Hakutuloksia ".$leffat->num_rows." kpl.</h4><br>"; 
                    $kortti ="<div class = \"row\">";
                    while($rivi = $leffat->fetch_assoc()) { 
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
            mysqli_close($yhteys);
        }

        function generateQuery() {
            // SELECT category_id, count(category_id) FROM `film_category` GROUP BY category_id
            $query = "SELECT * FROM film f INNER JOIN film_category fa on f.film_id = fa.film_id where category_id =";
            $emptyQuery = strlen($query);

            if(isset($_POST['Action'])) {
                $query.="1"; 
            } elseif(isset($_POST['Animation'])) {
                $query.="2"; 
            } elseif(isset($_POST['Children'])) {
                $query.="3"; 
            } elseif(isset($_POST['Classics'])) {
                $query.="4"; 
            } elseif(isset($_POST['Comedy'])) {
                $query.="5"; 
            } elseif(isset($_POST['Documentary'])) {
                $query.="6"; 
            } elseif(isset($_POST['Drama'])) {
                $query.="7"; 
            } elseif(isset($_POST['Family'])) {
                $query.="8"; 
            } elseif(isset($_POST['Foreign'])) {
                $query.="9"; 
            } elseif(isset($_POST['Games'])) {
                $query.="10"; 
            } elseif(isset($_POST['Horror'])) {
                $query.="11"; 
            } elseif(isset($_POST['Music'])) {
                $query.="12"; 
            } elseif(isset($_POST['New'])) {
                $query.="13"; 
            } elseif(isset($_POST['Sci-Fi'])) {
                $query.="14"; 
            } elseif(isset($_POST['Sports'])) {
                $query.="15"; 
            } elseif(isset($_POST['Travel'])) {
                $query.="16"; 
            }
            if(strlen($query)>$emptyQuery) {
                return $query;
            } 
        }

?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>