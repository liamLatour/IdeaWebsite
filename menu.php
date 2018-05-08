<style>
    #menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 25%;
        background-color: #c7c7c7;
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
        background-color: #555;
        color: white;
    }
    #menu .active {
        background-color: #4CAF50;
        color: white;
    }
    #menu div.rightAlign{
        margin-top: 50px;
    }
    @media screen and (max-width: 900px) {
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
        }
        #menu div.rightAlign li{
            float: right;
        }
        #menu div.rightAlign{
            margin-top: 0px;
        }
    }
    @media screen and (max-width: 500px) {
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
    <li><a <?php if ($activate == '1'){echo 'class="active"';} ?> href="index.php">Home</a></li>
    <li><a <?php if ($activate == '2'){echo 'class="active"';} ?> href="output.php">Be Inspired</a></li>
    <li><a <?php if ($activate == '3'){echo 'class="active"';} ?> href="input.php">Inspire</a></li>
    <li><a <?php if ($activate == '4'){echo 'class="active"';} ?> href="about.php">About</a></li>
    <div class="rightAlign">
    <li><a <?php if ($activate == '6'){echo 'class="active"';} ?> href="login.php">Login</a></li>
    <li><a <?php if ($activate == '5'){echo 'class="active"';} ?> href="register.php">Register</a></li>
    </div>
</ul>
</div>
