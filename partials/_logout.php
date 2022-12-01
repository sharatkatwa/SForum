<?php

    echo "logging you out please wait";

    session_start();
    session_destroy();
    header("Location: /php_tutorials/FORUM/index.php?logoutsuccess=true");

?>