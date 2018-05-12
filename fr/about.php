<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/tests/info.css">
<title>Une idée?</title>
<style>
div.content a{
    text-decoration: none;
    color: green;
}
.purp{
    padding: 60px;
    background-color: rgb(170,170,170);
    margin: 0px;
}
.usage{
    padding: 60px;
    background-color: rgb(160,160,160);
    margin: 0px;
}
.hist{
    margin: 0px;
    padding: 60px;
    background-color: rgb(180,180,180);
}
.me{
    margin: 0px;
    padding: 60px;
    background-color: rgb(190,190,190);
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '4';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<?php
$hastoshow = false;
if(isset($_POST['sub'])){
    if(!isset($_POST['subject']) OR $_POST['subject'] == ""){
        $hastoshow = true;
        echo "<script type='text/javascript'>alert('Please specify a subject');</script>";
    }
    elseif(!isset($_POST['msg']) OR $_POST['msg'] == ""){
        $hastoshow = true;
        echo "<script type='text/javascript'>alert('Please fill in the message box');</script>";
    }
    else{
        $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
        mail('liam.latour@gmail.com', $_POST['subject'], $_POST['msg'], $headers);
    }
}
else{
    $hastoshow = true;
}
?>
<div class="purp">
    <h1>Objectif</h1>
    <p>Ce site web est fait pour aider les personnes en manques d'idées<br>
    Aussi il permet à tous le monde de voir leurs idées se réaliser
    </p>
</div>
<div class="usage">
    <h1>Utilisation</h1>
    <p>Le titre doit être bref mais tous de même faire comprendre se que vous voulez</br>
    Le message en lui même peut donner autant d'information que vous voulez:</br>
       -L'idée de base</br>
       -Un début de projet</br>
       -Ou juste un titre</br>
    </p>
</div>
<div class="hist">
    <h1>Histoire</h1>
    <p>Au début ce site à été fait pour apprendre comment php, MySQL et html marche ensemble
    et aussi pour avoir des idées moi même</p>
    <a href="https://github.com/liamLatour/IdeaWebsite">Le code source se trouve sur github</a>
</div>
<div class="me">
<h1>Le créateur</h1>
    <p>Je suis un étudiant français de 17 ans qui ne veux qu'apprendre l'informatique</p>
    <?php
    if($hastoshow){
    ?>
    <p>Envoiez moi se que vous pensez du site</p>
    <form action="about.php" method="post">
    <ul class="form-style-1">
        <li>
            <label>Sujet</span></label>
            <input type="text" name="subject" class="field-long" />
        </li>
        <li>
            <label>Votre message</label>
            <textarea name="msg" id="msg" class="field-long field-textarea"></textarea>
        </li>
        <li>
            <input type="submit" value="Send" name="sub" />
        </li>
    </ul>
    </form>
    <?php
    }
    else{
    ?>
        <p>Merci pour le retour ;)</p>
    <?php
    }
    ?>
</div>
</div>
</body>
</html>