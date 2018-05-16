<?php
session_start();
require_once("./../mdp.php");

if (isset($_GET['disp']) AND $_GET['disp'] != ''){
    $f = ($_GET['disp']-1) * 10;
}
else{
    $f = 0;
}
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
    .content ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: rgb(220, 220, 220);
        overflow: auto;
    }
    .sidenav a {
        color: #000;
        padding: 15px;
        text-decoration: none;
        text-align: center;
    }
    .sidenav a:hover:not(.active) {
        background-color: rgb(236, 159, 5);
        color: white;
    }
    .content .active {
        background-color: rgb(110, 211, 100);
        color: white;
    }
    .content ul.sidenav li{
        display: inline-block;
        padding: 15px;
    }
    .submenu{
        text-align: center;
    }

    .naviguate{
        background-color: rgb(200,200,200);
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
        margin: 20px;
    }
    </style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '2';
include("menu.php");

if(isset($_GET['cat'])){
    $cat = $_GET['cat'];
}
else{
    $cat = "nonne";
}
?>

<!--Input-->
<div class="content" align="center">
<div class="submenu">
    <ul class="sidenav">
        <li><a href="output.php?cat=phil" <?php if ($cat == 'phil'){echo 'class="active"';} ?>>Philo</a></li>
        <li><a href="output.php?cat=soft" <?php if ($cat == 'soft'){echo 'class="active"';} ?>>Soft</a></li>
        <li><a href="output.php?cat=nat" <?php if ($cat == 'nat'){echo 'class="active"';} ?>>Nature</a></li>
        <li><a href="output.php?cat=eng" <?php if ($cat == 'eng'){echo 'class="active"';} ?>>Engineering</a></li>
        <li><a href="output.php?cat=oth" <?php if ($cat == 'oth'){echo 'class="active"';} ?>>Other</a></li>
        <li><a href="output.php?cat=lik" <?php if ($cat == 'lik'){echo 'class="active"';} ?>>Liked</a></li>
        <li><a href="output.php?cat=rep" <?php if ($cat == 'rep'){echo 'class="active"';} ?>>Replied</a></li>
    </ul>
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

if(isset($_GET['cat'])){
    switch($_GET['cat']){
        case "phil":
        ?>
<h1>Ideas about philosophy</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 AND categorie=1 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "soft":
        ?>
<h1>Ideas about software</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 AND categorie=4 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "nat":
        ?>
<h1>Ideas about nature</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 AND categorie=3 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "eng":
        ?>
<h1>Ideas about engineering</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 AND categorie=2 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "oth":
        ?>
<h1>Ideas about other things</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 AND categorie=5 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "lik":
        ?>
<h1>Most liked ideas</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 ORDER BY likes DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
        case "rep":
        ?>
<h1>Last ideas replied</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();

            break;
        default:
        ?>
<h1>Last ideas given</h1>
        <?php
            $reponse = $bdd->prepare('SELECT * FROM news WHERE parent=0 ORDER BY id DESC LIMIT :f, 10');
            $reponse->bindValue(':f', $f, PDO::PARAM_INT);
            $reponse->execute();
            break;
    }
}
else{
    ?>
        <h1>Last ideas given</h1>
    <?php
    $reponse = $bdd->prepare("SELECT * FROM news WHERE parent=0 ORDER BY id DESC LIMIT :f, 10");
    $reponse->bindValue(':f', $f, PDO::PARAM_INT);
    $reponse->execute();
}

$nb = 0;
$already = [];

while ($donnees = $reponse->fetch())
{
    $nb += 1;

    if(in_array($donnees['parent'], $already) OR in_array($donnees['id'], $already)){
        continue;
    }

    if($donnees['titre'] == ''){
        array_push($already, $donnees['parent']);
        $subst = $bdd->prepare('SELECT * FROM news WHERE id=:id');
        $subst->execute(array('id' => $donnees['parent']));
        $donnees = $subst->fetch();
    }
    else{
        array_push($already, $donnees['id']);
    }

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
        <?php
            $output = $donnees['contenu'];
            include("./../beautiful.php");
        ?>
        </p>
        <h7>
        Replies: <?php echo $replies->fetchColumn() ?> ---- Likes: <?php 

        echo $donnees['likes'] 

        ?>
        </h7>
    </div>
    </a>
<?php
}
$reponse->closeCursor();

if(isset($_GET['disp']) AND $_GET['disp'] > 1){
?>
<a class="naviguate" href="output.php?cat=<?php if(isset($_GET['cat'])){echo $_GET['cat'];} ?>&disp=<?php if(isset($_GET['disp'])){echo (int) $_GET['disp']-1;}else{echo 1;} ?>">Previous</a>
<?php
}
if($nb == 10){
?>
<a class="naviguate" href="output.php?cat=<?php if(isset($_GET['cat'])){echo $_GET['cat'];} ?>&disp=<?php if(isset($_GET['disp'])){echo (int) $_GET['disp']+1;}else{echo 2;} ?>">Next</a>
<?php
}
?>
</div>
</body>
</html>