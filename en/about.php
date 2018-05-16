<?php
session_start();
require_once("./../mdp.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./../info.css">
<link rel="stylesheet" type="text/css" href="./../reset.css">
<title>Une idée?</title>
<style>
div.content a{
    text-decoration: none;
    color: green;
}
.purp{
    padding: 60px;
    background-color: rgb(170,170,170);
    margin: 0px;
}
.usage{
    padding: 60px;
    background-color: rgb(160,160,160);
    margin: 0px;
}
.hist{
    margin: 0px;
    padding: 60px;
    background-color: rgb(180,180,180);
}
.me{
    margin: 0px;
    padding: 60px;
    background-color: rgb(190,190,190);
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '4';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<?php
$hastoshow = false;
if(isset($_POST['sub'])){
    if(!isset($_POST['subject']) OR $_POST['subject'] == ""){
        $hastoshow = true;
        echo "<script type='text/javascript'>alert('Please specify a subject');</script>";
    }
    elseif(!isset($_POST['msg']) OR $_POST['msg'] == ""){
        $hastoshow = true;
        echo "<script type='text/javascript'>alert('Please fill in the message box');</script>";
    }
    else{
        $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
        mail('liam.latour@gmail.com', $_POST['subject'], $_POST['msg'], $headers);
    }
}
else{
    $hastoshow = true;
}
?>
<div class="purp">
    <h1>Purpose</h1>
    <p>This website is meant to help people in lack of ideas<br>
    Also it makes it possible for everyone to have a working example of their dream</p>
</div>
<div class="usage">
    <h1>Usage</h1>
    <p>The title has to be brief but to describe what you want</br>
    In the core message you can give as many details as you want:</br>
       -The basic idea</br>
       -Some leads or start of project</br>
       -Or simply a title</br>
    </p>
</div>
<div class="hist">
    <h1>History</h1>
    <p>At the begining it was meant to learn how php, MySQL and html works together and also to have some ideas myself</p>
    <a href="https://github.com/liamLatour/IdeaWebsite">Repository on GitHub for source code</a>
</div>
<div class="me">
<h1>The creator</h1>
    <p>I'm a 17 years old french student eager to learn computer science</p>
    <?php
    if($hastoshow){
    ?>
    <p>Send me feedback to improve myself </p>
    <form action="about.php" method="post">
    <ul class="form-style-1">
        <li>
            <label>Subject</span></label>
            <input type="text" name="subject" class="field-long" />
        </li>
        <li>
            <label>Your Message</label>
            <textarea name="msg" id="msg" class="field-long field-textarea"></textarea>
        </li>
        <li>
            <input type="submit" value="Send" name="sub" />
        </li>
    </ul>
    </form>
    <?php
    }
    else{
    ?>
        <p>Thanks for the feedback ;)</p>
    <?php
    }
    ?>
</div>
</div>
</body>
</html>