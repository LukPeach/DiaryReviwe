<?php
    session_start();
    include_once('functions.php');
    $userdata = new DB_con();

    $userid = $_SESSION['id'];

    if ($_SESSION['id'] == "") {
        header("location: index.php");
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

    <div class="timeline">
        <?php
            $result = $userdata->yourcaption();
            $postBoxes = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $captionId = $row['id'];
                    $caption = $row['caption'];
                    $descaption = $row['descaption'];
                    $image = $row['image'];
                    $uid = $row['uid'];
                    $regdate = $row['time'];

                    $html = "<div class='post-boxtimeline'>";
                    $html .= "<h3>$caption</h3>";
                    $html .= "<div class='image'>";
                    $html .= "<img src='uploads/$image' alt=''>";
                    $html .= "</div>";
                    $html .= "<p>Date: $regdate</p>";
                    $html .= "<p>$descaption</p>";
                    $html .= "</div>";

                    $postBoxes[] = $html;
                }

                $postBoxes = array_reverse($postBoxes);

                foreach ($postBoxes as $html) {
                    echo $html;
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
