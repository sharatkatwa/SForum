
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


    <?php 
    $catid = $_GET['catid'];
      $query = "SELECT * FROM `categories` WHERE category_id=$catid";
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_assoc($result)){
        $catName = $row['category_name'];
        $catDesc = $row['category_description'];
      }
    ?>

<?php
$showAlert = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // INSERT THREAD INTO DB
        $user_id = $_POST['userid'];
        $th_title = $_POST['thread_title'];
            $th_title = str_replace(">","&gt;","$th_title");
            $th_title = str_replace("<","&lt;","$th_title");
        $th_desc = $_POST['thread_desc'];
            $th_desc = str_replace(">","&gt;","$th_desc");
            $th_desc = str_replace("<","&lt;","$th_desc");
        $query4 = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`)
                 VALUES ('$th_title', '$th_desc', '$catid', '$user_id');";
        $result4 = mysqli_query($conn, $query4);
        $showAlert = true;
    }
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUCCESS!</strong> your thread uploaded successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <!-- jumbotron container starts here -->
    <div class="container my-4 bg-light mb-5">
        <div class="jumbotron">
            <h1 class="display-4">
                Welcome to <?php echo $catName; ?> forums
            </h1>
            <p class="lead">
                <?php echo $catDesc; ?>
            </p>
            <hr class="my-4">
            <p>This is a peer to peer forum
                No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.
            </p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php
    
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        // <!-- Question adding Form container starts here -->
        echo '<div class="container">
                <h1>Ask your Questions here</h1>
                <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                    <div class="my-3">
                        <label for="thread_title" class="form-label">Problem title</label>
                        <input type="text" class="form-control" id="thread_title" name="thread_title"  placeholder="Enter thread title here">
                    </div>
                    <div class="mb-3">
                        <label for="thread_desc" class="form-label">Elaborate your concern</label>
                        <textarea class="form-control" id="thread_desc" name="thread_desc" rows="2"></textarea>
                        <input type="hidden" name="userid" value="'.$_SESSION["userid"].'">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
    }
    else {
        echo '<div class="container">
            <h1>Ask your Questions</h1>
            <div class="jumbotron jumbotron-fluid py-5 mt-3 bg-secondary text-light text-center" >
                <p class="display-5">You are not loggedin!</p>
                <p class="lead">you need to login first before you post something.
                <a class="mx-2 text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a>
                <a class="ml-2 text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#signupModal">Signup here</a></p>
            </div>
        </div>';
        
    }
    ?>
<!-- fetching Questions from table starts here -->
    <div class="container" style="min-height:400px;">
        <h1 class="py-3">Browse Questions</h1>
        <?php 
                $catid = $_GET['catid'];
                $noResult = true;
                $query2 = "SELECT * FROM `threads` WHERE thread_cat_id=$catid";
                $result2 = mysqli_query($conn, $query2);
                while($row2 = mysqli_fetch_assoc($result2)){
                    $noResult = false;
                    $threadTitle = $row2['thread_title'];
                    $threadDesc = $row2['thread_desc'];
                    $threadId = $row2['thread_id'];
                    $postedTime = $row2['date_time'];
                    $th_user_id =$row2['thread_user_id'];
                    // to display the username on thread
                    $sql2="SELECT user_name FROM `users` WHERE slno='$th_user_id'";
                    $result3 = mysqli_query($conn, $sql2);
                    $row3 = mysqli_fetch_assoc($result3);
                    
                    

                    echo'<div class="media py-2 d-flex">
                            <img class="mr-3" width="50px" height=55px src="images/userdefault.png" alt="...">
                            <div class="media-body mx-3">
                                
                                <h5 class="mt-0"><a class="text-dark" style="text-decoration:none;" href="thread.php?threadId='.$threadId.'">'.$threadTitle.'</a></h5>
                                <a class="text-dark" style="text-decoration:none;" href="thread.php">'.$threadDesc.'</a>
                                <h6 class="mt-0">Asked By: '.$row3['user_name'].' at '.$postedTime.'</h6>
                                </div>
                           
                            
                            
                        </div>';
                }
            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid py-5 mt-5 bg-secondary text-light" >
                    <div class="container text-center">
                        <p class="display-5">Question not found!</p>
                        <p class="lead">Be the first person to ask queries.</p>
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