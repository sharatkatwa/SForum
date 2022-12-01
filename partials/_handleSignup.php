<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '_dbconnect.php';
        
        $username = $_POST['signupName'];
        $email = $_POST['signupEmail'];
        $pass = $_POST['signupPass'];
        $cpass = $_POST['signupCpass'];
    
    // check whether this email exists or not
    $emailExistSql = "SELECT * FROM `users` WHERE user_email='$email'";
    $resultEmail = mysqli_query($conn, $emailExistSql);
    $noOfRowsExists = mysqli_num_rows($resultEmail);
     // check whether this username exists or not
     $nameExistSql = "SELECT * FROM `users` WHERE user_name='$username'";
     $resultName = mysqli_query($conn, $nameExistSql);
     $noOfRowsExists2 = mysqli_num_rows($resultName);

    if ($noOfRowsExists > 0) {
        $showEmailError = "Email already Exists";
        header("Location: /php_tutorials/FORUM/index.php?signupsuccess=false&error=$showEmailError");
    }
    elseif ($noOfRowsExists2 > 0) {
        $showNameError = "Username already Exists";
        header("Location: /php_tutorials/FORUM/index.php?signupsuccess=false&error=$showNameError");
    }
    elseif ($noOfRowsExists > 0 && $noOfRowsExists2 > 0) {
        $showBothError = "Username and Email already exists";
        header("Location: /php_tutorials/FORUM/index.php?signupsuccess=false&error=$showBothError");
    }
    else {
        if ($pass == $cpass) {
            $showAlert = false;
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_pass`)
                    VALUES ('$username', '$email', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("Location: /php_tutorials/FORUM/index.php?signupsuccess=true");
            }
            else {
                echo "signup not successful";
            }
        }
        else {
            $showPassError = "Passwords do not match";
            header("Location: /php_tutorials/FORUM/index.php?signupsuccess=false&error=$showPassError");
        }
    }
}

?>