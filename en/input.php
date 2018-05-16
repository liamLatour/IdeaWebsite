<?php
session_start();
require_once("./../mdp.php");

if(isset($_SESSION['username'])){
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type']))
    {
        if(trim($_POST['field5']) != "" AND trim($_POST['field3']) != ""){
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $password);
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
            $req = $bdd->prepare('INSERT INTO news(titre, contenu, owner, categorie, parent) VALUES(:titre, :contenu, :owner, :categorie, :parent)');
            $req->execute(array(
                'titre' => $_POST['field3'],
                'contenu' => $_POST['field5'],
                'owner' => $_SESSION['username'],
                'categorie' => $_POST['type'],
                'parent' => 0
                ));
            
            header('Location: output.php');
            
        }
        else{
            $hasttoshow = true;
        }
    }
    else{
        $hasttoshow = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./../info.css">
<link rel="stylesheet" type="text/css" href="./../reset.css">
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
.categori{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
figure {
    display: inline-block;
    padding: 0px;
    margin: 10px;
}
figcaption {
    margin: 10px 0 0 0;
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
$activate = '3';
include("menu.php"); 
?>
<!--
Had some kind of categories:
    -Software       blue    4
    -Philosophy    brown    1
    -Nature         green   3
    -Engineering    orange  2
    -Other          gray    5
-->


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



<div class="content" align="center">
<?php
$hasttoshow = false;

if(isset($_SESSION['username'])){
    ?>
    <form action="input.php" method="post">
    <label class="categori">Categories</label>
    <ul class = "type">
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="1">
            <img src="./../philo.jpg" width="40" height="40" alt="Philosophy">
            </label>
            <figcaption>Philosophy</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="2">
            <img src="./../eng.jpg" width="40" height="40" alt="Engineering">
            </label>
            <figcaption>Engineering</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="3">
            <img src="./../nature.jpg" width="40" height="40" alt="Nature">
            </label>
            <figcaption>Nature</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="4">
            <img src="./../software.jpeg" width="40" height="40" alt="Software">
            </label>
            <figcaption>Software</figcaption>
            </figure>
        </li>
        <li>
            <figure>
            <label>
            <input type="radio" name="type" value="5">
            <img src="./../other.png" width="40" height="40" alt="Other">
            </label>
            <figcaption>Other</figcaption>
            </figure>
        </li>
    </ul>
    <ul class="form-style-1">
        <li>
            <label>Title</label>
            <input type="text" name="field3" class="field-long" />
        </li>
        <li>
            <label>Your Message</label>
            <button onclick="addcol('**bold  bold**')" type=button><b>B</b></button>
            <button onclick="addcol('**italic  italic**')" type=button><i>i</i></button>
            <button onclick="addcol('**mark  mark**')" type=button><mark>M</mark></button>
            <button onclick="addcol('**sup  sup**')" type=button><sup>s</sup></button>
            <button onclick="addcol('**sub  sub**')" type=button><sub>s</sub></button>
            <button onclick="addcol('**insert  insert**')" type=button><ins>N</ins></button>

            <textarea name="field5" id="field5" class="field-long field-textarea"></textarea>

            <script>
                function addcol(towrite){
                    document.getElementById("field5").value += towrite;
                }
            </script>

        </li>
        <li>
            <input type="submit" value="Submit" />
            <button type=button onclick="show()">preview</button>

            <script>
                function show(){
                    var temp = document.getElementById("field5").value;
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
        </li>
    </ul>
    </form>
    <?php
    if(isset($_POST['field5']) AND isset($_POST['field3']) AND isset($_POST['type'])){
        echo "<h2>You must fill title AND message</h2>";
    }
    ?>
    <?php
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
    <a href="login.php">You must <u>login</u> first to submit ideas</a>
    </div>
    <div class="reg">
    <a href="register.php">If you don't have an account yet please <u>register</u></a>
    </div>
    <?php
}
?>
</div>
</body>
</html>