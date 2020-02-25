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
    <script src="sakilaScript.jsx" type="text/babel"></script>

</head>
<body>

<div id="nav"></div>

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
	
        <hr>
                
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>