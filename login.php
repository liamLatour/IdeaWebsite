<?php
session_start();
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
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'lumi/2003');
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