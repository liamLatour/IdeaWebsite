<?php
session_start();
require_once("./../mdp.php");

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

if(isset($_POST['like'])){
    if(isset($_SESSION['id'])){
        $verif = $bdd->prepare('SELECT * FROM liked WHERE user=:user AND idea=:idea');
        $verif->execute(array(
            'user' => $_SESSION['id'],
            'idea' => $_POST['like']
            ));

        if($verif->rowCount() == 0){

            $owner = $bdd->prepare('SELECT owner FROM news WHERE id=:id');
            $owner->execute(array('id' => $_POST['like']));
            $trueown = $owner->fetch()['owner'];

            if($trueown != $_SESSION['username']){
                $reputation = $bdd->prepare('UPDATE users SET points=points+2 WHERE username=:id');
                $reputation->execute(array('id' => $trueown));

                $main = $bdd->prepare('UPDATE news SET likes=likes+1 WHERE id=:id');
                $main->execute(array('id' => $_POST['like']));

                $unable = $bdd->prepare('INSERT INTO liked(user, idea) VALUES(:user, :idea)');
                $unable->execute(array(
                    'user' => $_SESSION['id'],
                    'idea' => $_POST['like']
                    ));
            }
            else{
                echo '<script type="text/javascript">window.alert("You can not like your own post");</script>';
            }
        }
        else{
            echo '<script type="text/javascript">window.alert("You already liked this !");</script>';
        }
    }
    else{
        echo '<script type="text/javascript">window.alert("You have to be connected");</script>';
    }
}

$main = $bdd->prepare('SELECT * FROM news WHERE id=:id');
$main->execute(array('id' => $_GET['id']));
$retrive = $main->fetch();

$hastoshow = false;

if(isset($_SESSION['username'])){
    if(isset($_POST['msg']))
    {
        if(trim($_POST['msg']) != ""){

            $owner = $bdd->prepare('SELECT owner FROM news WHERE id=:id');
            $owner->execute(array('id' => $_GET['id']));
            $trueown = $owner->fetch()['owner'];

            if($trueown != $_SESSION['username']){
                $reputation = $bdd->prepare('UPDATE users SET points=points+1 WHERE username=:id');
                $reputation->execute(array('id' => $trueown));
            }

            $req = $bdd->prepare('INSERT INTO news(titre, contenu, owner, categorie, parent) VALUES(:titre, :contenu, :owner, :categorie, :parent)');
            $req->execute(array(
                'titre' => '',
                'contenu' => $_POST['msg'],
                'owner' => $_SESSION['username'],
                'categorie' => $retrive['categorie'],
                'parent' => $_GET['id']
                ));
        }
        else{
            $hastoshow = true;
        }
    }
    else{
        $hastoshow = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="./../color.css">
    <link rel="stylesheet" type="text/css" href="./../info.css">
    <link rel="stylesheet" type="text/css" href="./../reset.css">
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

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 5px auto; /* 15% from the top and centered */
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        /* Position it in the top right corner outside of the modal */
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    /* Close button on hover */
    .close:hover,
    .close:focus {
        color: red;
        cursor: pointer;
    }
    .container{
        padding: 20px;
        text-align: center;
    }

    /* Add Zoom Animation */
    .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
        from {-webkit-transform: scale(0)}
        to {-webkit-transform: scale(1)}
    }

    @keyframes animatezoom {
        from {transform: scale(0)}
        to {transform: scale(1)}
    } 
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '2';
include("menu.php");
?>

<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
    <div class="container" style="background-color:#f1f1f1">
    <p id="showoff">
        lol
    </p>
    </div>
</div>

<!--Input-->
<div class="content" align="center">

<?php

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
        <td>
            <a href="users.php?id=<?php echo $retrive['owner'];?>">By: <?php echo htmlspecialchars($retrive['owner']);?></a>
        </td>
        <td class="title"><?php echo htmlspecialchars($retrive['titre']); ?></td>
        <td><?php echo htmlspecialchars($retrive['date']); ?></td>
    </table>
    <p>
    <?php
        $output = $retrive['contenu'];
        include("./../beautiful.php");
    ?>
    </p>
    Likes: <?php echo $retrive['likes'] ?>
    <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <label>
        <input type="submit" name="like" value="<?php echo $_GET['id'] ?>">
        <img src="./../like.png" width="40" height="40" alt="Like" >
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
            <td>
                <a href="users.php?id=<?php echo $donnees['owner'];?>">'<?php echo htmlspecialchars($donnees['owner']);?>' replied</a>
            </td>
            <td><?php echo htmlspecialchars($donnees['date']); ?></td>
        </table>
        <p>
        <?php
            $output = $donnees['contenu'];
            include("./../beautiful.php");
        ?>
        </p>
        Likes: <?php echo $donnees['likes'] ?>
        <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <label>
            <input type="submit" name="like" value="<?php echo $donnees['id'] ?>">
            <img src="./../like.png" width="40" height="40" alt="Like" >
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
    if($hastoshow == true){
    ?>
    <form action="Idea.php?id=<?php echo $_GET['id'] ?>" method="post">
    <ul class="form-style-1">
        <li>
            <label>Reply</label>
            <button onclick="addcol('**bold  bold**')" type=button><b>B</b></button>
            <button onclick="addcol('**italic  italic**')" type=button><i>i</i></button>
            <button onclick="addcol('**mark  mark**')" type=button><mark>M</mark></button>
            <button onclick="addcol('**sup  sup**')" type=button><sup>s</sup></button>
            <button onclick="addcol('**sub  sub**')" type=button><sub>s</sub></button>
            <button onclick="addcol('**insert  insert**')" type=button><ins>N</ins></button>

            <textarea name="msg" id="msg" class="field-long field-textarea"></textarea>

            <script>
                function addcol(towrite){
                    document.getElementById("msg").value += towrite;
                }
            </script>
        </li>
        <li>
            <input type="submit" value="Submit" />
        </li>
    </ul>
    </form>
    <button type=button onclick="show()">preview</button>
    <script>
        function show(){
            var temp = document.getElementById("msg").value;
            var temp = temp.replace("**bold", "<b>");
            var temp = temp.replace("bold**", "</b>");

            var temp = temp.replace("**italic", "<i>");
            var temp = temp.replace("italic**", "</i>");

            var temp = temp.replace("**mark", "<mark>");
            var temp = temp.replace("mark**", "</mark>");

            var temp = temp.replace("**sup", "<sup>");
            var temp = temp.replace("sup**", "</sup>");

            var temp = temp.replace("**sub", "<sub>");
            var temp = temp.replace("sub**", "</sub>");

            var temp = temp.replace("**insert", "<ins>");
            var temp = temp.replace("insert**", "</ins>");

            document.getElementById("showoff").innerHTML = temp;
            document.getElementById('id01').style.display='block';
        }
    </script>
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