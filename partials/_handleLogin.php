<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';

    $logEmail = $_POST['loginEmail'];
    $logPass = $_POST['loginPass'];

    $sql = "SELECT * FROM users WHERE user_email='$logEmail'";
    $result = mysqli_query($conn, $sql);
    $noOfRowsExists = mysqli_num_rows($result);
    if ($noOfRowsExists == 1) {
        while($row = mysqli_fetch_assoc($result)){
            if (password_verify($logPass, $row['user_pass'])) {
                
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["useremail"] = $logEmail;
                $_SESSION["username"] = $row['user_name'];
                $_SESSION["userid"] = $row['slno'];
                header("Location: /php_tutorials/FORUM/index.php?loginsuccess=true");
            }
            else {
                $loginError = "Incorrect username or password, Unable to login";
                header("Location: /php_tutorials/FORUM/index.php?error=$loginError");
            }
        }
    }
    else {
        $loginError = "Incorrect username or password, Unable to login";
        header("Location: /php_tutorials/FORUM/index.php?error=$loginError");
    }

}

?>