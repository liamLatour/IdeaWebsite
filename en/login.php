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
.glob{
    padding: 40px;
    background-color: rgb(190,190,190);
    margin: 0px;
}
.loged{
    margin: 0px;
    padding: 40px;
    background-color: rgb(180,180,180);
}
.failed{
    margin: 0px;
    padding: 10px;
    background-color: rgb(255,20,20);
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '6';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<?php
$astoshow = false;
if(isset($_POST['mail']) AND isset($_POST['passwd']))
{
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents(__DIR__ . '/../mdp.txt'));
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $verif = $bdd->prepare("SELECT * FROM users WHERE email = :mail");
    $verif->execute(array('mail' => $_POST['mail']));
    $donnees = $verif->fetch();

    $olo = password_verify(trim($_POST['passwd']), $donnees['password']);

    if($olo){
        $_SESSION['username'] = $donnees['username'];
        $_SESSION['mail'] = $donnees['email'];
        $_SESSION['password'] = trim($_POST['passwd']);
        $_SESSION['id'] = $donnees['id'];
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
            <h1>Logged in succesful !!!!</h1>
        </div>
        <div class="loged">
            <h2>Welcome back <?php echo $_SESSION['username'] ?> !</h2>
        </div>
        <?php
    }
    else{
        ?>
        <div class="failed">
            <h1>Wrong credentials...</h1>
        </div>
        <?php
        $astoshow = true;
    }
}
else{
    $astoshow = true;
}

if (isset($_SESSION['username']) AND !isset($_POST['mail'])){
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
        <h1>Already logged in !</h1>
    </div>
    <?php
}
elseif($astoshow == true){
?>
<form action="login.php" method="post">
<ul class="form-style-1">
    <li>
        <label>Email</label>
        <input type="email" name="mail" class="field-long" />
    </li>
    <li>
        <label>Password</label>
        <input type="password" name="passwd" class="field-long" />
    </li>
    <li>
        <input type="submit" value="Login" />
    </li>
</ul>
</form>
<?php
}
?>
</div>
</body>
</html>