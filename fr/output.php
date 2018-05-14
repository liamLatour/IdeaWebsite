<?php
session_start();
require_once("./../mdp.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./../color.css">
    <title>Une idée?</title>
    <style>
    a{
        text-decoration: none;
        color: black;
    }
    p{
        padding: 20px;
        margin: auto;
    }
    td{
        text-align: center;

    }
    tr{
        width: 70%;
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
<h1>Dernières idées</h1>

<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM news WHERE parent=0 ORDER BY id DESC');

while ($donnees = $reponse->fetch())
{
    $replies = $bdd->prepare('SELECT COUNT(*) FROM news WHERE parent=:parent');
    $replies->execute(array('parent' => $donnees['id']));
?>
    <a href="Idea.php?id=<?php echo $donnees['id'] ?>">
    <div class="idea<?php echo $donnees['categorie'] ?>">
        <table class="table" border=0 style="table-layout: fixed; width:100%">
            <td class="td">Par: <?php echo htmlspecialchars($donnees['owner']);?></td>
            <td class="title"><?php echo htmlspecialchars($donnees['titre']); ?></td>
            <td class="td"><?php echo htmlspecialchars($donnees['date']); ?></td>
        </table>
        <p>
            <?php echo htmlspecialchars($donnees['contenu']); ?>
        </p>
        <h7>
        Réponses: <?php echo $replies->fetchColumn() ?> ---- Likes: <?php echo $donnees['likes'] ?>
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