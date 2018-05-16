<?php
session_start();
require_once("./../mdp.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./../color.css">
    <link rel="stylesheet" type="text/css" href="./../reset.css">
    <title>Une idée?</title>
    <style>
    .glob{
        padding: 40px;
        background-color: rgb(190,190,190);
        margin: 0px;
    }
    .loged{
        margin: 0px;
        padding: 60px;
        background-color: rgb(180,180,180);
    }
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
    .comment {
        background-color: rgb(150, 150, 150);
        padding: 5px;
    }
    td{
        text-align: center;

    }
    </style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '7';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$user = $bdd->prepare('SELECT * FROM users WHERE username=:id');
$user->execute(array('id' => $_GET['id']));
$data = $user->fetch();
?>
<div class="glob">
    <h1>Profile of: <?php echo $data['username'] ?></h1>
    <h2>Points: <?php echo $data['points'] ?></h2>
    <?php
    switch ($data['points']){
        case $data['points'] = 0:
            echo "<h2>nouveau</h2>";
            break;
        case $data['points'] > 500:
            echo "<h2>génie</h2>";
            break;
        case $data['points'] > 400:
            echo "<h2>homme de science</h2>";
            break;
        case $data['points'] > 300:
            echo "<h2>concepteur</h2>";
            break;
        case $data['points'] > 250:
            echo "<h2>penseur</h2>";
            break;
        case $data['points'] > 100:
            echo "<h2>aviseur</h2>";
            break;
        case $data['points'] > 50:
            echo "<h2>songeur</h2>";
            break;
        case $data['points'] > 20:
            echo "<h2>rêveur</h2>";
            break;
        default:
            echo "<h2>nouveau</h2>";
            break;
    }
    ?>
</div>
<div>
    <?php
    $reponse = $bdd->prepare('SELECT * FROM news WHERE owner=:owner ORDER BY id DESC');
    $reponse->execute(array('owner' => $data['username']));

    if($reponse->rowCount() > 0){
        ?>
        <h2><?php echo $data['username'] ?>'s posts</h2>
        <?php
        while ($donnees = $reponse->fetch())
        {
            if($donnees['titre'] == ""){
            ?>
                <div class="response">
                    <table border=0 style="table-layout: fixed; width:100%">
                        <td>'<?php echo htmlspecialchars($donnees['owner']);?>' replied</td>
                        <td><?php echo htmlspecialchars($donnees['date']); ?></td>
                    </table>
                    <p>
                    <?php
                        $output = $donnees['contenu'];
                        include("./../beautiful.php");
                    ?>
                    </p>
                </div>
            <?php
            }
            else{
            $replies = $bdd->prepare('SELECT COUNT(*) FROM news WHERE parent=:parent');
            $replies->execute(array('parent' => $donnees['id']));
            ?>
            <a href="Idea.php?id=<?php echo $donnees['id'] ?>">
            <div class="idea<?php echo $donnees['categorie'] ?>">
                <table border=0 style="table-layout: fixed; width:100%" class="table">
                    <td class="td">By: <?php echo htmlspecialchars($donnees['owner']);?></td>
                    <td class="title"><?php echo htmlspecialchars($donnees['titre']); ?></td>
                    <td class="td"><?php echo htmlspecialchars($donnees['date']); ?></td>
                </table>
                <table border=0 style="table-layout: fixed; width:100%" id="core">
                    <td width="120px">
                        Replies: <?php echo $replies->fetchColumn() ?>                        
                    </td>
                    <td>
                    <?php
                        $output = $donnees['contenu'];
                        include("./../beautiful.php");
                    ?>
                    </td>
                    <td width="10px">

                    </td>
                </table>
                <form>

                </form>
            </div>
            </a>
            <?php
            }
        }
        $reponse->closeCursor();
    }
    else{
        ?>
        <h2><?php echo $data['username'] ?> has not posted anything yet</h2>
        <?php
    }
    ?>
</div>
</div>
</body>
</html>