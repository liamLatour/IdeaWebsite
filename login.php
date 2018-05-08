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
    padding: 0px 10px;
}
.form-style-1 {
    margin: auto;
    max-width: 800px;
    padding: 20px 12px 10px 20px;
    font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}
.form-style-1 label{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
.form-style-1 input[type=text],
.form-style-1 input[type=email],
.form-style-1 input[type=password]{
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
.form-style-1 input[type=text]:focus,
.form-style-1 input[type=email]:focus,
.form-style-1 input[type=password]:focus{
    -moz-box-shadow: 0 0 8px #88D5E9;
    -webkit-box-shadow: 0 0 8px #88D5E9;
    box-shadow: 0 0 8px #88D5E9;
    border: 1px solid #88D5E9;
}
.form-style-1 .field-divided{
    width: 49%;
}
.form-style-1 .field-long{
    width: 100%;
}
.form-style-1 input[type=submit]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
.form-style-1 input[type=submit]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
.form-style-1 .required{
    color:red;
}
</style>
</head>
<body>
<!--Menu-->
<?php 
$activate = '6';
include("menu.php");
?>

<!--Input-->
<div class="content" align="center">
<form>
<ul class="form-style-1">
    <li>
        <label>Email</label>
        <input type="email" name="field3" class="field-long" />
    </li>
    <li>
        <label>Password</label>
        <input type="password" name="field4" class="field-long" />
    </li>
    <li>
        <input type="submit" value="Login" />
    </li>
</ul>
</form>
</div>
</body>
</html>