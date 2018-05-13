<?php
session_start();
require_once("./../mdp.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./../color.css">
    <title>Une idée?</title>
    <style>
    a.button {
        text-decoration: none;
        color: initial;
        padding: 10px 10px;
    }
    a.button:hover{
        background-color: rgb(220, 220, 220);
    }
    .idea{
        background-color: rgb(220, 220, 220);
        margin-top: 20px;
        margin-bottom: 30px;
        margin-right: 40px;
        margin-left: 40px;
        max-width: 800px;
    }
    .postidea{
        background-color: rgb(238, 238, 238);
        padding: 50px 10px;
    }
    p{
        padding: 20px;
        margin: auto;
    }
    table, td {
        background-color: rgb(150, 150, 150);
        padding: 5px;
    }
    td{
        text-align: center;

    }
    .title{
        background-color: rgb(170,170,170);
    }
    a{
        text-decoration: none;
        color: black;
    }
    </style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '1';
include("menu.php");
?>

<style>
.content{
    padding: 10px 10px;
}
</style>

<!--Input-->
<div class="content" align="center">
<div class="postidea">
<a href="input.php" class="button">Post an Idea</a>
<h2>Last ideas</h2>
</div>

<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM news WHERE parent=0 ORDER BY id DESC LIMIT 0, 5');

while ($donnees = $reponse->fetch()){
    $replies = $bdd->prepare('SELECT COUNT(*) FROM news WHERE parent=:parent');
    $replies->execute(array('parent' => $donnees['id']));
?>
<a href="Idea.php?id=<?php echo $donnees['id'] ?>">
    <div class="idea<?php echo $donnees['categorie'] ?>">
        <table class="table" border=0 style="table-layout: fixed; width:100%">
            <td class="td">By: <?php echo htmlspecialchars($donnees['owner']);?></td>
            <td class="title"><?php echo htmlspecialchars($donnees['titre']); ?></td>
            <td class="td"><?php echo htmlspecialchars($donnees['date']); ?></td>
        </table>
        <p>
            <?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
        </p>
        <h7>
        Replies: <?php echo $replies->fetchColumn() ?> ---- Likes: <?php echo $donnees['likes'] ?>
        </h7>
    </div>
</a>
<?php
}
$reponse->closeCursor();
?>
</div>
</body>
</html>