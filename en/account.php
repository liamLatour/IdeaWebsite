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

if(isset($_POST['pass'])){
    $req = $bdd->prepare('UPDATE users SET password=:pass WHERE id=:id');
    $req->execute(array(
        'pass' => password_hash($_POST['pass'], PASSWORD_DEFAULT),
        'id' => $_SESSION['id']
        ));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./../color.css">
    <title>Une idée?</title>
    <style>
    .glob{
        padding: 1%;
        background-color: rgb(190,190,190);
        margin: 0px;
    }
    .loged{
        margin: 0px;
        padding: 1%;
        background-color: rgb(180,180,180);
    }

    @media screen and (max-width: 600px) {
        .glob {
            font-size: 10px;
        }
        .loged{
            font-size: 9px;
        }
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
    .comment {
        background-color: rgb(150, 150, 150);
        padding: 5px;
    }
    td{
        text-align: center;

    }
    button{
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
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
    }

    input[type=password]{
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

    input[type=submit],
    button[type=submit]{
        background: #4B99AD;
        padding: 8px 15px 8px 15px;
        border: none;
        color: #fff;
        margin-top: 10px;
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
$activate = '7';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">


<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="account.php" method="post">

    <div class="container">
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pass" required>

      <button type="submit">Modify</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>



<?php
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
    <button onclick="document.getElementById('id01').style.display='block'"><h2>Change password</h2></button>
    <form action="account.php" method="post">
        <input type="submit" name="logout" value="Log out">
    </form>
</div>

<div id="answers">
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
                        <?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
                    </p>
                    <form action="account.php#answers" method="post" onSubmit="return confirm('Are you sure you want to proceed?');">
                        <button type="submit" name="del" value="<?php echo $donnees['id'] ?>">Delete</button>
                    </form>
                    <form action="modify.php" method="post">
                        <button type="submit" name="mod" value="<?php echo $donnees['id'] ?>">Modify</button>
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
                            <button type="submit" name="del" value="<?php echo $donnees['id'] ?>">Delete</button>
                        </form>
                        <form action="modify.php" method="post">
                            <button type="submit" name="mod" value="<?php echo $donnees['id'] ?>">Modify</button>
                        </form>
                        
                    </td>
                    <td>
                        <?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
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