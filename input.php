<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="info.css">
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
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type']))
    {
        if(trim($_POST['field5']) != "" AND trim($_POST['field3']) != ""){
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'lumi/2003');
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
            ?>
            <style>
            .content{
                position: absolute;
                top: 25%;
                left: 0;
                right: 0;
            }
            </style>
            <div class="glob">
            <h1>Your message has been set !</h1>
            </div>
            <?php
        }
        else{
            $hasttoshow = true;
        }
    }
    else{
        $hasttoshow = true;
    }

    if($hasttoshow == true){
    ?>
    <form action="input.php" method="post">
    <ul class = "type">
        <li>
            <label>
            <input type="radio" name="type" value="1">
            <img src="philo.jpg" width="40" height="40">
            </label>
        </li>
        <li>
            <label>
            <input type="radio" name="type" value="2">
            <img src="eng.jpg" width="40" height="40">
            </label>
        </li>
        <li>
            <label>
            <input type="radio" name="type" value="3">
            <img src="nature.jpg" width="40" height="40">
            </label>
        </li>
        <li>
            <label>
            <input type="radio" name="type" value="4">
            <img src="software.jpeg" width="40" height="40">
            </label>
        </li>
        <li>
            <label>
            <input type="radio" name="type" value="5">
            <img src="other.png" width="40" height="40">
            </label>
        </li>
    </ul>
    <ul class="form-style-1">
        <li>
            <label>Title</label>
            <input type="text" name="field3" class="field-long" />
        </li>
        <li>
            <label>Your Message</label>
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
    <a href="login.php">You must <u>login</u> first to submit ideas</a>
    </div>
    <div class="reg">
    <a href="register.php">If you don't have an account yet please <u>register</u></a>
    </div>
    <?php
}
?>
</div>
</body>
</html>