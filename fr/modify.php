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
$activate = '7';
include("menu.php"); 
?>

<style>
.content{
    margin-top: 0px;
}
</style>

<div class="content" align="center">
<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents("/opt/lampp/htdocs/tests/mdp.txt"));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$hasttoshow = false;
if(isset($_POST['mod'])){
    $_SESSION['curid'] = $_POST['mod'];
}
else{
    if(!isset($_SESSION['curid'])){
        echo "Something went wrong :(";
        exit;
    }
}

if(isset($_SESSION['username'])){
    if(isset($_POST['field5']) AND isset($_SESSION['curid']))
    {
        if(trim($_POST['field5']) != ""){
            $req = $bdd->prepare('UPDATE news SET contenu=:contenu WHERE id=:id');
            $req->execute(array(
                'contenu' => $_POST['field5'],
                'id' => $_SESSION['curid']
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
            <h1>Votre message à été modifié !</h1>
            </div>
            <?php
            unset($_SESSION['curid']);
        }
        else{
            $hasttoshow = true;
        }
    }
    else{
        $hasttoshow = true;
    }

    if($hasttoshow == true){
        $req = $bdd->prepare('SELECT contenu FROM news WHERE id=:id');
        $req->execute(array('id' => $_SESSION['curid']));
    ?>
    
    <form action="modify.php" method="post">
    <ul class="form-style-1">
        <li>
            <label>Modifié votre mesage</label>
            <textarea name="field5" id="field5" class="field-long field-textarea"><?php echo $req->fetch()['contenu'] ?></textarea>
        </li>
        <li>
            <input type="submit" value="Submit" />
        </li>
    </ul>
    </form>

    <?php
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type'])){
        echo "<h2>Vous devez tous remplir</h2>";
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
    <a href="login.php">Vous devez vous <u>connecter</u> avant de modifier</a>
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