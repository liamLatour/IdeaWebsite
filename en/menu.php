<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="./../favicon.ico">
<style>
    body {
        margin: 0px;
        background-color: rgb(240,240,240);
    }
    #menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: rgb(200, 200, 200);
        position: fixed; 
        overflow: auto;
    }
    #menu a {
        display: block;
        color: #000;
        padding: 15px;
        text-decoration: none;
        text-align: center;
    }
    #menu a:hover:not(.active) {
        background-color: rgb(236, 159, 5);
        color: white;
    }
    #menu .active {
        background-color: rgb(142, 166, 4);
        color: white;
    }
    #menu ul.sidenav {
        width: 100%;
        height: auto;
        position: relative;
    }
    #menu ul.sidenav li a {
        float: left;
        padding: 15px;
    }
    div.content {
        margin-left: 0;
        padding: 0px;
    }
    #menu div.rightAlign li{
        float: right;
    }
    #menu div.rightAlign{
        margin-top: 0px;
    }

    #menu hr{
        display:none;
    }
    #menu ul.hide{
        display:none;
    }


    #menu .minus{
        display: none;
    }

    @media screen and (max-width: 600px) {
        #menu ul.sidenav li a {
            text-align: center;
            float: none;
        }
        #menu div.rightAlign li{
            float: none;
        }
        #menu div.rightAlign{
            margin-top: 0px;
        }
        #menu hr{
            display: block;
        }

        #menu div.rightAlignH li{
            float: right;
        }
        #menu div.rightAlignH{
            margin-top: 0px;
        }
        #menu ul.hide {
            width: 100%;
            height: auto;
            position: relative;
        }
        #menu ul.hide li a {
            float: left;
            padding: 15px;
        }
        #menu ul.sidenav{
            display:none;
        }
        #menu ul.hide{
            display:block;
        }

        #menu .minus{
            display: inline-block;
            margin: 0px;
            padding: 0px;
            width: 49%;
        }
        #menu .next{
            display: inline-block;
            margin: 0px;
            padding: 0px;
            width: 49%;
        }
    }
</style>
<div id="menu">
<ul class="hide">
        <li><a <?php if ($activate == '1'){echo 'class="active"';} ?> href="index.php">Home</a></li>
    <div class="rightAlignH">
        <li><a href="#" onclick="show();return false;">▾</a></li>
    </div>
</ul>

<ul class="sidenav">
    <li><a <?php if ($activate == '1'){echo 'class="active"';} ?> href="index.php">Home</a></li>
    <li><a <?php if ($activate == '2'){echo 'class="active"';} ?> href="output.php">Be Inspired</a></li>
    <li><a <?php if ($activate == '3'){echo 'class="active"';} ?> href="input.php">Inspire</a></li>
    <li><a <?php if ($activate == '4'){echo 'class="active"';} ?> href="about.php">About</a></li>

    <hr>

    <div class="rightAlign">
        <?php
        if (isset($_SESSION['username'])){
        ?>
            <li><a <?php if ($activate == '7'){echo 'class="active"';} ?> href="account.php">Logged in as:  <?php echo $_SESSION['username'] ?></a></li>
        <?php
        }
        else{
        ?>
            <li><a <?php if ($activate == '6'){echo 'class="active"';} ?> href="login.php">Login</a></li>
            <li><a <?php if ($activate == '5'){echo 'class="active"';} ?> href="register.php">Register</a></li>
        <?php
        }
        ?>

        <li class="next"><a href="./../fr/index.php">FR</a></li>
        <li class="minus"><a href="#" onclick="hide();return false;">▴</a></li>
    </div>

    
</ul>
</div>

<script type="text/javascript">
    var big = document.getElementsByClassName("sidenav")[0];

    var small = document.getElementsByClassName("hide")[0];

    function show(){
        big.style.display = 'inline-block';
        small.style.display = 'none';
    }

    function hide(){
        big.style.display = 'none';
        small.style.display = 'block';
    }
</script>