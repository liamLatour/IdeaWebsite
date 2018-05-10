<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="color.css">
    <link rel="stylesheet" type="text/css" href="info.css">
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
        background-color: rgb(220, 220, 220);
        margin-top: 20px;
        margin-bottom: 30px;
        margin-right: 80px;
        margin-left: 80px;
        max-width: 700px;
    }
    .owner{
        background-color: rgb(210,210,210);
        padding: auto;
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
$activate = '2';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">

<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'lumi/2003');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

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
        <h1>Wrong Page</h1>
    </div>
    <?php
}
else{
?>
<div class="idea">
    <table border=0 style="table-layout: fixed; width:100%">
        <td>By: <?php echo htmlspecialchars($retrive['owner']);?></td>
        <td class="title"><?php echo htmlspecialchars($retrive['titre']); ?></td>
        <td><?php echo htmlspecialchars($retrive['date']); ?></td>
    </table>
    <p>
        <?php echo htmlspecialchars($retrive['contenu']); ?>
    </p>
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
            <td class="owner" width="150px">By: <?php echo htmlspecialchars($donnees['owner']);?>
            <?php echo htmlspecialchars($donnees['date']); ?></td>
            <td><?php echo htmlspecialchars($donnees['contenu']); ?></td>
        </table>
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
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'lumi/2003');
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
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
            <h1>Your reply has been set !</h1>
            </div>
            <?php
        }
        else{
        ?>
        <h2>You must fill the reply</h2>
        <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="post">
        <ul class="form-style-1">
            <li>
                <label>Reply</label>
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
            <label>Reply</label>
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
            <a href="login.php">You must <u>login</u> first to reply to ideas</a>
        </div>
        <div class="reg">
            <a href="register.php">If you don't have an account yet please <u>register</u></a>
        </div>
    <?php
}
}
?>


</div>
</body>
</html>