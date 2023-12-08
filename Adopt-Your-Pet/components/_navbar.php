<?php
echo "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid w-100'>
        <img src='assets/logo-sm.png' alt='logo of Adopt-Your-Pet' id='logo-in-navbar'>
        <a class='navbar-brand' href='home.php' id='logo-text'>Adopt-Your-Pet</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <div class='d-flex justify-content-between w-100'>
                <div> </div>
                <div>
                    <ul class='navbar-nav d-flex w-100'>
                        <li class='nav-item'>
                            <a class='nav-link' href='home.php'>Home</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='senior.php'>Senior pets</a>
                        </li>
    ";
if(isset($_SESSION["adm"])) {
    echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='dashboard.php'>Dashboard</a>
                        </li>                
     ";
}
if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='register.php'>Register</a>
                        </li>                       
                        <li class='nav-item'>
                            <a class='nav-link' href='login.php'>Login</a>
                        </li>
    ";
}
if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
    echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='components/logout.php?logout'>Logout</a>
                        </li>
    ";
}
    echo "
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
";

