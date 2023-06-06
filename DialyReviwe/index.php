<?php

    session_start();
    include_once('functions.php');
    $userdata = new DB_con();
    
    if(isset($_POST['login'])){
        $uname = $_POST['username'];
        $password = md5($_POST['password']);

        $result = $userdata->signin($uname, $password);
        $num = mysqli_fetch_array($result);

        if($num > 0){
            $_SESSION['id'] = $num['id'];
            $_SESSION['fname'] = $num['fullname'];
            echo "<script>alert('Login Successful!');</script>";
            echo "<script>window.location.href='welcome.php'</script>";
        }
        else{
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='index.php'</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in page</title>
    
    <link rel="stylesheet" type="text/css" href="styleLogin.css">

</head>
<body>
    
    <section>
        <div class="form-box">
            <div class="form-login">
                <form method="post">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" id="username" name="username" required>
                        <label for="username">User name</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox" class="left">Remember Me <a href="#" class="right">Forget Password</a></label>
                    </div>
                    <button type="submit" name="login">Log in</button>
                    <div class="register">
                        <p>Don't have a account <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</body>
</html>