<?php
 if (isset($_GET['msg'])){
     $msg = $_GET['msg'];
 }else{
     $msg = null;
 }
?>
<?php require_once "helpers/sessionHelper.php"?>
<?php
$ses = new sessionHelper();
$ses->isLogged();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="homepage">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
       
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="adminLogin.php">Admin</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lecturerLogin.php" tabindex="-1" aria-disabled="true">Lecture</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" tabindex="-1" aria-disabled="true">Student</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="form-log container d-flex justify-content-center align-items-center">
        <div class="card col-md-4 pt-2 pb-2 border-0">
           
            <form action="route/route.php" method="post">
                <h4 class="text-center">Student Login</h4>
                <?php
                if ($msg != null){
                    echo "<p class='text-danger'>$msg</p>";
                }else{
                    echo "  <p class=\"pb-2 text-primary\">Enter your login credentials</p>";
                }
                ?>
                <div class="form-group">
                  <input type="text" class="form-control" name="username" id="" aria-describedby="helpId" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" id="" aria-describedby="helpId" placeholder="Password">
                </div>
                <button class="btn btn-block btn-primary" name="login" type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>