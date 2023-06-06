<?php
    session_start();
    include_once('functions.php');
    $userdata = new DB_con();

    $userid = $_SESSION['id'];

    if ($_SESSION['id'] == "") {
        header("location: index.php");
    }

    // Delete caption
    if (isset($_POST['delete'])) {
        $captionId = $_POST['captionId'];
        $userdata->deleteCaption($captionId);
        header("location: welcome.php");
    }

    // Update caption
    if (isset($_POST['bedit'])) {
        $captionId = $_POST['captionId'];
        $caption = $_POST['caption'];
        $descaption = $_POST['decaption'];
        $uid = $userid;
    
        $userdata->updateCaption($captionId, $caption, $descaption, $uid);
        header("location: welcome.php");
    }

    $countcol = $userdata->countcol();

    if (isset($_POST['bpost'])) {
        $caption = $_POST['caption'];
        $descaption = $_POST['decaption'];
        $uid = $userid;

        // Code for image upload
        $image = $_FILES['imageUpload']['name'];
        $temp_image = $_FILES['imageUpload']['tmp_name'];
        $upload_dir = "uploads/";

        move_uploaded_file($temp_image, $upload_dir . $image);

        $sql = $userdata->post($caption, $descaption, $image, $uid);

        if ($sql) {
            echo "<script>alert('Post Successful!');</script>";
            echo "<script>window.location.href='welcome.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='welcome.php'</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
    <link rel="stylesheet" type="text/css" href="stylewelcome.css">
</head>
<body>
    <header>
        <a href="timeline.php" class="username">WELCOME <?php echo $_SESSION['fname']; ?></a>
        <ul>
            <li><a href="timeline.php">Time Line</a></li>
            <li><a href="welcome.php">Porfile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </header>  
    <section class="banner"> 
        <div class="form-box">
            <div class="databox">
                <form method="post" enctype="multipart/form-data">
                    <h2>POST</h2>
                    <div class="inputbox">
                        <label for="caption">Caption</label>
                        <input type="text" id="caption" name="caption" required>
                    </div>
                    <div class="inputbox">
                        <label for="decaption">Decaption</label>
                        <input type="text" id="decaption" name="decaption">
                    </div>                    
                    <div class="inputfile">
                        <label for="imageUpload">Upload Image</label>
                        <input type="file" id="imageUpload" name="imageUpload">
                    </div>
                    <button type="submit" name="bpost" id="bpost" class="buttonwel">Post</button>
                </form>
            </div>
        </div>
    </section>

    <div class="post-area">
        <?php
            $result = $userdata->yourcaption();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $captionId = $row['id'];
                    $caption = $row['caption'];
                    $descaption = $row['descaption'];
                    $image = $row['image'];
                    $uid = $row['uid'];
                    $regdate = $row['time'];
                
                    if ($uid == $userid) {
                        echo "<div class='post-box'>";
                        echo "<h3>$caption</h3>";
                        echo "<div class='image'>";
                        echo "<img src='uploads/$image' alt=''>";
                        echo "</div>";
                        echo "<p>Date:$regdate</p>";
                        echo "<p>$descaption</p>";
                        echo "</div>";
                        echo "<div class='edit-form hidden'>";
                        echo "<h3>EDIT</h3>";
                        echo "<form method='post' enctype='multipart/form-data'>";
                        echo "<input type='hidden' name='captionId' value='$captionId'>";
                        echo "<div class='inputedit'>";
                        echo "<input type='text' name='caption' value='$caption'>";
                        echo "</div>";
                        echo "<div class='inputedit'>";
                        echo "<input type='text' name='decaption' value='$descaption'>";
                        echo "</div>";
                        echo "<button class='inputeditbutton' type='submit' name='bedit'>Save</button>";
                        echo "<button class='inputeditbutton' type='submit' name='delete'>Delete</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                }                
            } 
        ?>
    </div>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        });

        var editButtons = document.getElementsByClassName('edit');
        for (var i = 0; i < editButtons.length; i++) {
            editButtons[i].addEventListener('click', function(e) {
                var postBox = e.target.parentNode.parentNode;
                var editForm = postBox.getElementsByClassName('edit-form')[0];
                editForm.classList.toggle('hidden');
            });
        }
    </script>

</body>
</html>
