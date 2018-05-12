<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/tests/color.css">
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
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', file_get_contents("/opt/lampp/htdocs/tests/mdp.txt"));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

if(isset($_POST['del'])){
    $owned = $bdd->prepare('SELECT * FROM news WHERE owner=:owner AND id=:id');
    $owned->execute(array('owner' => $_SESSION['username'], 'id' => $_POST['del']));
    if($owned->rowCount() > 0){
        $del = $bdd->prepare('DELETE FROM news WHERE id=:id OR parent=:id');
        $del->execute(array('id' => $_POST['del']));
    }
}

if(isset($_POST['logout'])){
    session_destroy();
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
        <h1>Log out succesfull</h1>
    </div>
    <?php
}
elseif(!isset($_SESSION['username'])){
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
        <h1>Already logged out</h1>
    </div>
    <?php
}
else{
?>
<div class="glob">
    <h1>Loged in as: <?php echo $_SESSION['username'] ?></h1>
</div>
<div class="loged">
    <h2>Your email: <?php echo $_SESSION['mail'] ?></h2>
    <h2>Your password: <?php echo $_SESSION['password'] ?></h2>
    <form action="account.php" method="post">
        <input type="submit" name="logout" value="Log out">
    </form>
</div>
<div>
    <?php
    $reponse = $bdd->prepare('SELECT * FROM news WHERE owner=:owner ORDER BY id DESC');
    $reponse->execute(array('owner' => $_SESSION['username']));

    if($reponse->rowCount() > 0){
        ?>
        <h2>Your posts</h2>
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
                        <?php echo htmlspecialchars($donnees['contenu']); ?>
                    </p>
                    <form action="account.php" method="post" onSubmit="return confirm('Are you sure you want to proceed?');">
                        <button name="del" value="<?php echo $donnees['id'] ?>">Delete</button>
                    </form>
                    <form action="modify.php" method="post">
                        <button name="mod" value="<?php echo $donnees['id'] ?>">Modify</button>
                    </form>
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

                        <form action="account.php" method="post" onSubmit="return confirm('Are you sure you want to proceed?');">
                            <button name="del" value="<?php echo $donnees['id'] ?>">Delete</button>
                        </form>
                        <form action="modify.php" method="post">
                            <button name="mod" value="<?php echo $donnees['id'] ?>">Modify</button>
                        </form>
                        
                    </td>
                    <td>
                        <?php echo htmlspecialchars($donnees['contenu']); ?>
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
        <h2>You have not posted anything yet</h2>
        <?php
    }
    ?>
</div>
<?php
}
?>
</div>
</body>
</html>