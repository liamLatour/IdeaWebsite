<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 25%;
        background-color: #c7c7c7;
        height: 100%; 
        position: fixed; 
        overflow: auto;
    }

    li a {
        display: block;
        color: #000;
        padding: 15px;
        text-decoration: none;
        text-align: center;
    }

    li a:hover:not(.active) {
        background-color: #555;
        color: white;
    }
    .active {
        background-color: #4CAF50;
        color: white;
    }

    @media screen and (max-width: 900px) {
        ul.sidenav {
            width: 100%;
            height: auto;
            position: relative;
        }
        ul.sidenav li a {
            float: left;
            padding: 15px;
        }
        div.content {
            margin-left: 0;
            padding: 0px 0px;
        }
        li.rightAlign{
            float: right;
        }
    }

    @media screen and (max-width: 400px) {
        ul.sidenav li a {
            text-align: center;
            float: none;
        }
        li.rightAlign{
            float: none;
        }
    }
</style>

<ul class="sidenav">
    <li><a class="active" href="index.html">Home</a></li>
    <li><a href="news.asp">News</a></li>
    <li><a href="contact.asp">Contact</a></li>
    <li><a href="about.asp">About</a></li>
    <li class="rightAlign"><a href="login.php">Login</a></li>
    <li class="rightAlign"><a href="register.php">Register</a></li>
</ul> 