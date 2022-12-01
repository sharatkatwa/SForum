<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>SForum - Coding Forums</title>
</head>

<body>
    <?php 
        include 'partials/_dbconnect.php';
        include 'partials/_header.php';
    ?>

<!-- add posted comment to table -->
<?php
        $thread_id = $_GET['threadId'];
        $showAlert = false;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // INSERT comment INTO table
            $user_id = $_POST['userid'];
            $comment_content = $_POST['comment'];
            $comment_content = str_replace(">","&gt;","$comment_content");
            $comment_content = str_replace("<","&lt;","$comment_content");
            $query4 = "INSERT INTO `comments` (`comment_content`, `thread_id`, `user_id`) 
                        VALUES ('$comment_content', '$thread_id','$user_id')";
            $result4 = mysqli_query($conn, $query4);
            $showAlert = true;
        }
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Done!</strong> Your comment added successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>

<!-- jumbotron container starts here -->
<div class="container my-4 bg-light mb-5">
    <!-- to fetch content for jumbotron -->
    <?php
        $threadId = $_GET['threadId'];
        $query = "SELECT * FROM `threads` WHERE thread_id=$threadId";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $threadTitle = $row['thread_title'];
            $threadDesc = $row['thread_desc'];
            $th_user_id =$row['thread_user_id'];
                    // to display the username on jumbotron thread
                    $sql2="SELECT user_name FROM `users` WHERE slno='$th_user_id'";
                    $result3 = mysqli_query($conn, $sql2);
                    $row3 = mysqli_fetch_assoc($result3);
                    
        }
        ?>

        <div class="jumbotron">
            <h1 class="display-5"><?php echo $threadTitle; ?></h1>
            <p class="lead">
                <b>
                    <?php echo $threadDesc; ?>
                </b>
            </p>
            <hr class="my-4">
            <p class="lead">
                <small>
                    This is a peer to peer forum
                    No Spam / Advertising / Self-promote in the forums.
                    Do not post copyright-infringing material.
                    Do not post “offensive” posts, links or images.
                    Do not cross post questions.
                    Remain respectful of other members at all times.
                </small>
            </p>
            <p class="lead">
            Posted By:<b> <?php echo $row3['user_name'];?></b>
            </p>
        </div>
    </div>
<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        //  <!-- comment post form starts here -->
        echo '<div class="container">
            <h1>Post a comment</h1>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            
                <div class="mb-3">
                    <label for="comment" class="form-label">type here</label>
                    <textarea class="form-control" id="comment" name="comment" rows="2"></textarea>
                    <input type="hidden" name="userid" value="'.$_SESSION["userid"].'">
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>';
    }
    else {
        echo '<div class="container">
            <h1>Post a comment</h1>
            <div class="jumbotron jumbotron-fluid py-5 mt-3 bg-secondary text-light text-center" >
                <p class="display-5">You are not loggedin!</p>
                <p class="lead">you need to login first before you comment.
                <a class="mx-2 text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a>
                <a class="ml-2 text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#signupModal">Signup here</a></p>
            </div>
        </div>';
        
    }
    ?>

    
<!-- comment displaying container starts here -->
    <div class="container" style="min-height:500px;">
        <h1 class="py-3">Discussions</h1>
        <?php 
            
                $noResult = true;
                $query2 = "SELECT * FROM `comments` WHERE thread_id=$thread_id";
                $result2 = mysqli_query($conn, $query2);
                while($row2 = mysqli_fetch_assoc($result2)){
                    $noResult = false;
                    $commentContent = $row2['comment_content'];
                    $commentId = $row2['comment_id'];
                    $commentTime = $row2['comment_time'];
                    $comm_user_id =$row2['user_id'];
                    // to display the username on jumbotron thread
                    $sql5="SELECT user_name FROM `users` WHERE slno='$comm_user_id'";
                    $result5 = mysqli_query($conn, $sql5);
                    $row5 = mysqli_fetch_assoc($result5);

                    echo'<div class="media py-2 d-flex">
                        <img class="mr-3" width="50px" src="images/userdefault.png" alt="...">
                        <div class="media-body mx-3">
                        '.$commentContent.'
                        <h6 class="mt-0">Comment By: '.$row5['user_name'].' at '.$commentTime.'</h6>
                        </div>
                        </div>';
                }
            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid py-5 mt-5 bg-secondary text-light" >
                    <div class="container text-center">
                        <p class="display-5">No Answers yet!</p>
                        <p class="lead">Wait until replay.</p>
                    </div>
                    </div>';
            }

        ?>

    </div>
    <?php include 'partials/_footer.php'; ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>