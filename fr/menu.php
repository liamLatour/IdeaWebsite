<style>
    body {
        margin: 0px;
        background-color: rgb(240,240,240);
    }
    #menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 25%;
        background-color: rgb(200, 200, 200);
        height: 100%; 
        position: fixed; 
        overflow: auto;
    }
    #menu li a {
        display: block;
        color: #000;
        padding: 15px;
        text-decoration: none;
        text-align: center;
    }
    #menu li a:hover:not(.active) {
        background-color: rgb(236, 159, 5);
        color: white;
    }
    #menu .active {
        background-color: rgb(142, 166, 4);
        color: white;
    }
    #menu div.rightAlign{
        margin-top: 50px;
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

    @media screen and (max-width: 550px) {
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
    }
</style>

<div id="menu">
<ul class="sidenav">
    <li><a <?php if ($activate == '1'){echo 'class="active"';} ?> href="index.php">Accueil</a></li>
    <li><a <?php if ($activate == '2'){echo 'class="active"';} ?> href="output.php">Etre inspiré</a></li>
    <li><a <?php if ($activate == '3'){echo 'class="active"';} ?> href="input.php">Inspiré</a></li>
    <li><a <?php if ($activate == '4'){echo 'class="active"';} ?> href="about.php">A propos</a></li>
    <div class="rightAlign">
    <?php
    if (isset($_SESSION['username'])){
    ?>
        <li><a <?php if ($activate == '7'){echo 'class="active"';} ?> href="account.php">Connecté:  <?php echo $_SESSION['username'] ?></a></li>
    <?php
    }
    else{
    ?>
        <li><a <?php if ($activate == '6'){echo 'class="active"';} ?> href="login.php">Se connecter</a></li>
        <li><a <?php if ($activate == '5'){echo 'class="active"';} ?> href="register.php">Inscription</a></li>
    <?php
    }
    ?>
    <li><a href="./../en/index.php">EN</a></li>
    </div>
</ul>
</div>