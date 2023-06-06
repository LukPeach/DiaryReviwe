<?php

    define('DB_SERVER', 'localhost'); //Your hostname
    define('DB_USER', 'root'); //Database Username
    define('DB_PASS', ''); //Database Password
    define('DB_NAME', 'dialyreviwe_sql'); //Database Name

    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQIL: " . mysqli_connect_error();
            }
        }

        public function usernameavailable($uname){
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM tblusers WHERE username
            = '$uname'");
            return $checkuser;
        }

        public function registration($fname, $uname, $uemail, $password) {
            $reg = mysqli_query($this->dbcon, "INSERT INTO tblusers(fullname, username, useremail, password)
            VALUES('$fname', '$uname', '$uemail', '$password')");
            return $reg;
        }

        public function signin($uname, $password){
            $signinquery = mysqli_query($this->dbcon, "SELECT id, fullname FROM tblusers WHERE username =
            '$uname' AND password = '$password'");
            return $signinquery;
        }

        public function post($caption, $descaption, $image, $uid){
            $pos = mysqli_query($this->dbcon, "INSERT INTO post(caption, descaption, image, uid)
            VALUES('$caption', '$descaption', '$image', '$uid')");
            return $pos;
        }

        public function countcol(){
            $sql = mysqli_query($this->dbcon, "SELECT count(id) as id FROM post");
            $row = mysqli_fetch_array($sql);
            $result = (int) $row['id'];
            return $result;
        }     
        
        public function yourcaption(){
            $yourcap = mysqli_query($this->dbcon, "SELECT id, caption, descaption, image, uid, time FROM post");
            return $yourcap;
        }

        public function deleteCaption($captionId) {
            $query = "DELETE FROM post WHERE id = '$captionId'";
            $result = mysqli_query($this->dbcon, $query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function updateCaption($captionId, $caption, $descaption, $uid) {
            
            $query = "UPDATE post SET caption = '$caption', descaption = '$descaption' WHERE id = '$captionId' AND uid = '$uid'";
            
            $connection = $this->dbcon;
            $result = mysqli_query($connection, $query);

            mysqli_close($connection);

            return $result;
        }
    }
?>