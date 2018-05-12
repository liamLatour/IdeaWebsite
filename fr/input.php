<?php
session_start();

if(isset($_SESSION['username'])){
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type']))
    {
        if(trim($_POST['field5']) != "" AND trim($_POST['field3']) != ""){
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents("/opt/lampp/htdocs/tests/mdp.txt"));
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
            $req = $bdd->prepare('INSERT INTO news(titre, contenu, owner, categorie, parent) VALUES(:titre, :contenu, :owner, :categorie, :parent)');
            $req->execute(array(
                'titre' => $_POST['field3'],
                'contenu' => $_POST['field5'],
                'owner' => $_SESSION['username'],
                'categorie' => $_POST['type'],
                'parent' => 0
                ));
            
            header('Location: output.php');
            
        }
        else{
            $hasttoshow = true;
        }
    }
    else{
        $hasttoshow = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/tests/info.css">
<title>Une idée?</title>
<style type="text/css">
a{
    color: #000;
    text-decoration: none;
    text-align: center;
}
.login{
    padding: 60px;
    background-color: rgb(190,190,190);
    margin: 0px;
}
.reg{
    margin: 0px;
    padding: 60px;
    background-color: rgb(180,180,180);
}
.glob{
    padding: 40px;
    background-color: rgb(190,190,190);
    margin: 0px;
}
.type li{
    display:inline;
}
label input{
    visibility: hidden;
    position: absolute;
}
label input+img{
    cursor:pointer;
    border:2px solid transparent;
}
label input:checked + img{
  border:2px solid #f00;
}
.categori{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
figure {
    display: inline-block;
    padding: 0px;
    margin: 10px;
}
figcaption {
    margin: 10px 0 0 0;
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '3';
include("menu.php"); 
?>

<style>
.content{
    margin-top: 0px;
}
</style>

<!--
Had some kind of categories:
    -Software       blue    4
    -Philosophy    brown    1
    -Nature         green   3
    -Engineering    orange  2
    -Other          gray    5
-->

<div class="content" align="center">
<?php
$hasttoshow = false;

if(isset($_SESSION['username'])){
    ?>
    <form action="input.php" method="post">
    <label class="categori">Categories</label>
    <ul class = "type">
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="1">
            <img src="/tests/philo.jpg" width="40" height="40" alt="Philosophie">
            </label>
            <figcaption>Philosophie</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="2">
            <img src="/tests/eng.jpg" width="40" height="40" alt="Ingénierie">
            </label>
            <figcaption>Ingénierie</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="3">
            <img src="/tests/nature.jpg" width="40" height="40" alt="Nature">
            </label>
            <figcaption>Nature</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="4">
            <img src="/tests/software.jpeg" width="40" height="40" alt="Software">
            </label>
            <figcaption>Software</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="5">
            <img src="/tests/other.png" width="40" height="40" alt="Autre">
            </label>
            <figcaption>Autre</figcaption>
            </figure>
        </li>
    </ul>
    <ul class="form-style-1">
        <li>
            <label>Titre</label>
            <input type="text" name="field3" class="field-long" />
        </li>
        <li>
            <label>Votre Message</label>
            <textarea name="field5" id="field5" class="field-long field-textarea"></textarea>
        </li>
        <li>
            <input type="submit" value="Submit" />
        </li>
    </ul>
    </form>
    <?php
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type'])){
        echo "<h2>You must fill title AND message</h2>";
    }
    ?>
    <?php
}
else{
    ?>
    <style>
    .content{
        position: absolute;
        top: 25%;
        left: 0;
        right: 0;
    }
    </style>
    <div class="login">
    <a href="login.php">Vous devez vous <u>connecter</u> avant de poster</a>
    </div>
    <div class="reg">
    <a href="register.php">Si vous n'avez pas de compte <u>enregistré</u> vous</a>
    </div>
    <?php
}
?>
</div>
</body>
</html>