<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./../info.css">
<title>Une idée?</title>
<style>
.form-style-1 {
    margin: auto;
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
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents(__DIR__ . '/../mdp.txt'));
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
        <label>Username</label>
        <input type="text" name="usname" class="field-long" placeholder="Ex: BarFoo" />
    </li>
    <li>
        <label>Email</label>
        <input type="email" name="mail" class="field-long" placeholder="Ex: barfoo@email.com" />
    </li>
    <li>
        <label>Password</label>
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