<?php
session_start();
require_once("./../mdp.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<title>Une idée?</title>
<style>
.form-style-1 {
    margin: auto;
    max-width: 800px;
    padding: 20px 12px 10px 20px;
    font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}
.form-style-1 label{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
.form-style-1 input[type=text],
.form-style-1 input[type=email],
.form-style-1 input[type=password]{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border:1px solid #BEBEBE;
    padding: 7px;
    margin:0px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none; 
}
.form-style-1 input[type=text]:focus,
.form-style-1 input[type=email]:focus,
.form-style-1 input[type=password]:focus{
    -moz-box-shadow: 0 0 8px #88D5E9;
    -webkit-box-shadow: 0 0 8px #88D5E9;
    box-shadow: 0 0 8px #88D5E9;
    border: 1px solid #88D5E9;
}
.form-style-1 .field-divided{
    width: 49%;
}
.form-style-1 .field-long{
    width: 100%;
}
.form-style-1 input[type=submit]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
.form-style-1 input[type=submit]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
.form-style-1 .required{
    color:red;
}
.glob{
    padding: 10px;
    background-color: rgb(170,170,170);
    margin: 0px;
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '5';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">

<?php
$astoshow = false;
if(isset($_POST['usname']) AND isset($_POST['mail']) AND isset($_POST['passwd']))
{
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $verif = $bdd->prepare("SELECT id FROM users WHERE username = :usna");
    $verif->execute(array('usna' => $_POST['usname']));

    $verifm = $bdd->prepare("SELECT id FROM users WHERE email = :mail");
    $verifm->execute(array('mail' => $_POST['mail']));

    if(strlen(trim($_POST['passwd'])) < 6){
        echo '<div class="glob"><h3>Password is too short</h3></div>';
        $astoshow = true;
    }
    elseif(trim($_POST['usname']) == ""){
        echo '<div class="glob"><h3>You must enter a username</h3></div>';
        $astoshow = true;
    }
    elseif($verif->fetch()['id'] != ""){
        echo '<div class="glob"><h3>Username already taken</h3></div>';
        $astoshow = true;
    }
    elseif($verifm->fetch()['id'] != ""){
        echo '<div class="glob"><h3>Email already taken</h3></div>';
        $astoshow = true;
    }
    else{
        $req = $bdd->prepare("INSERT INTO users (username, email, password) VALUES(:username, :email, :password)");
        $req->execute(array(
            'username' => $_POST['usname'],
            'email' => $_POST['mail'],
            'password' => password_hash($_POST['passwd'], PASSWORD_DEFAULT)
        ));
        header("location: login.php");
    }
}
else{
    $astoshow = true;
}

if($astoshow == true){
?>
<form action="register.php" method="post">
<ul class="form-style-1">
    <li>
        <label>Pseudonime</label>
        <input type="text" name="usname" class="field-long" placeholder="Ex: BarFoo" />
    </li>
    <li>
        <label>Email</label>
        <input type="email" name="mail" class="field-long" placeholder="Ex: barfoo@email.com" />
    </li>
    <li>
        <label>Mot de passe</label>
        <input type="password" name="passwd" class="field-long" placeholder="Ex: S3cr3t"/>
    </li>
    <li>
        <input type="submit" value="Register"/>
    </li>
</ul>
</form>
<?php
}
?>
</div>
</body>
</html>