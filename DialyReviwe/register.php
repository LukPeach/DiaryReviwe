<?php
    include_once('functions.php');
    $userdata = new DB_con();

    if(isset($_POST['submit'])){
        $fname = $_POST['fullname'];
        $uname = $_POST['username'];
        $uemail = $_POST['email'];
        $password = md5($_POST['password']);

        $sql = $userdata->registration($fname, $uname, $uemail, $password);

        if($sql){
            echo "<script>alert('Regiter Successful!');</script>";
            echo "<script>window.location.href='index.php'</script>";
        }
        else{
            echo "<script>alert('Something went wrong! please try again.');</script>";
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
    <title>Register page</title>
    
    <link rel="stylesheet" type="text/css" href="styleLogin.css">

</head>
<body>
    
    <section>
        <div class="form-boxregister">
            <div class="form-register">
                <form method="post">
                    <h2>Register</h2>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" id="username" name="fullname" required>
                        <label for="fullname">Your name</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" id="username" name="username" required onblur= "checkusername(this.value)">
                        <label for="username">User name</label>
                        <span id ="usernameavailable"></span>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" id="email" name="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" name="submit" id="submit">Register</button>
                    <div class="backtologin">
                        <p>Have a account <a href="index.php">Login</a></p>
                    </div>
                </form>

            </div>
        </div>
    </section>
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        function checkusername(val){
            $.ajax({
                type: 'POST',
                url: 'checkuser_available.php',
                data: 'username='+val,
                success: function(data){
                    $('#usernameavailable').html(data);
                }
            })
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</body>
</html>