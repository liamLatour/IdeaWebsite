<?php
session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents("/opt/lampp/htdocs/tests/mdp.txt"));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
//
//Cant like if not connected
//
if(isset($_POST['like'])){
    if(isset($_SESSION['id'])){
        $verif = $bdd->prepare('SELECT * FROM liked WHERE user=:user AND idea=:idea');
        $verif->execute(array(
            'user' => $_SESSION['id'],
            'idea' => $_POST['like']
            ));

        if($verif->rowCount() == 0){
            $main = $bdd->prepare('UPDATE news SET likes=likes+1 WHERE id=:id');
            $main->execute(array('id' => $_POST['like']));

            $unable = $bdd->prepare('INSERT INTO liked(user, idea) VALUES(:user, :idea)');
            $unable->execute(array(
                'user' => $_SESSION['id'],
                'idea' => $_POST['like']
                ));
        }
        else{
            echo '<script type="text/javascript">window.alert("You already liked this !");</script>';
        }
    }
    else{
        echo '<script type="text/javascript">window.alert("You have to be connected");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="/tests/color.css">
    <link rel="stylesheet" type="text/css" href="/tests/info.css">
    <title>Une idée?</title>
    <style>
    h2{
        background-color: #FFF;
    }
    a{
        color: #000;
        text-decoration: none;
        text-align: center;
    }
    .idea{
        background-color: rgb(220, 220, 220);
        margin-top: 20px;
        margin-bottom: 30px;
        margin-right: 40px;
        margin-left: 40px;
        max-width: 800px;
    }
    .response{
        background-color: rgb(255, 255, 255);
        margin-top: 20px;
        margin-bottom: 30px;
        max-width: 800px;
        
        text-align: justify;
        text-justify: inter-word;
    }

    .response table, .response td {
        background-color: rgb(220, 220, 220);
        padding: 5px;
    }

    .owner{
        background-color: rgb(210,210,210);
        padding: auto;
    }
    p{
        padding: 20px;
        margin: auto;
    }
    .idea table, .idea td {
        background-color: rgb(150, 150, 150);
        padding: 5px;
    }
    td{
        text-align: center;

    }
    .title{
        background-color: rgb(170,170,170);
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

    img{
        margin-bottom: 5px;        
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
$activate = '2';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">

<?php
$main = $bdd->prepare('SELECT * FROM news WHERE id=:id');
$main->execute(array('id' => $_GET['id']));
$retrive = $main->fetch();

if($retrive['titre']==''){
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
        <h1>Mauvaise Page</h1>
    </div>
    <?php
}
else{
?>
<div class="idea">
    <table border=0 style="table-layout: fixed; width:100%">
        <td>Par: <?php echo htmlspecialchars($retrive['owner']);?></td>
        <td class="title"><?php echo htmlspecialchars($retrive['titre']); ?></td>
        <td><?php echo htmlspecialchars($retrive['date']); ?></td>
    </table>
    <p>
        <?php echo htmlspecialchars($retrive['contenu']); ?>
    </p>
    Likes: <?php echo $retrive['likes'] ?>
    <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <label>
        <input type="submit" name="like" value="<?php echo $_GET['id'] ?>">
        <img src="/tests/like.png" width="40" height="40" alt="Like" >
        </label>
    </form>
</div>

<?php
$reponse = $bdd->prepare('SELECT * FROM news WHERE parent=:parent');
$reponse->execute(array(
    'parent' => $_GET['id']
));

while ($donnees = $reponse->fetch()){
?>
    <div class="response">
        <table border=0 style="table-layout: fixed; width:100%">
            <td>'<?php echo htmlspecialchars($donnees['owner']);?>' on répondus</td>
            <td><?php echo htmlspecialchars($donnees['date']); ?></td>
        </table>
        <p>
            <?php echo htmlspecialchars($donnees['contenu']); ?>
        </p>
        Likes: <?php echo $donnees['likes'] ?>
        <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <label>
            <input type="submit" name="like" value="<?php echo $donnees['id'] ?>">
            <img src="like.png" width="40" height="40" alt="Like" >
        </label>
    </form>
    </div>
<?php
}
$reponse->closeCursor();
?>

<!--Comment section-->
<?php
if(isset($_SESSION['username'])){
    if(isset($_POST['msg']))
    {
        if(trim($_POST['msg']) != ""){
            $req = $bdd->prepare('INSERT INTO news(titre, contenu, owner, categorie, parent) VALUES(:titre, :contenu, :owner, :categorie, :parent)');
            $req->execute(array(
                'titre' => '',
                'contenu' => $_POST['msg'],
                'owner' => $_SESSION['username'],
                'categorie' => $retrive['categorie'],
                'parent' => $_GET['id']
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
            <h1>Réponse envoyé !</h1>
            </div>
            <?php
        }
        else{
        ?>
        <h2>Vous devez remplir la réponse</h2>
        <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="post">
        <ul class="form-style-1">
            <li>
                <label>Répondre</label>
                <textarea name="msg" id="msg" class="field-long field-textarea"></textarea>
            </li>
            <li>
                <input type="submit" value="Submit" />
            </li>
        </ul>
        </form>
        <?php
        }
    }
    else{
    ?>
    <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="post">
    <ul class="form-style-1">
        <li>
            <label>Répondre</label>
            <textarea name="msg" id="msg" class="field-long field-textarea"></textarea>
        </li>
        <li>
            <input type="submit" value="Submit" />
        </li>
    </ul>
    </form>
    <?php
    }
}
else{
    ?>
        <div class="login">
            <a href="login.php">Vous devez vous <u>connecter</u> avant de répondre</a>
        </div>
        <div class="reg">
            <a href="register.php">Si vous n'avez pas de compte <u>enregistré</u> vous</a>
        </div>
    <?php
}
}
?>


</div>
</body>
</html>