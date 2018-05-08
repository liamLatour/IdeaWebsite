<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <title>Une idée?</title>
    <style>
    body {
        margin: 0px;
    }
    div.content {
        margin-left: 25%;
        padding: 30px 10px;
    }
    a.button {
        background-color: rgb(238, 238, 238);
        text-decoration: none;
        color: initial;
        padding: 10px 10px;
    }
    </style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '1';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<a href="input.php" class="button">Post an Idea</a>
</div>
</body>
</html>