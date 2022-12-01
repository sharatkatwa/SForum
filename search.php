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
    <style>
        #maincontainer{
            min-height:78vh;
        }
    </style>
    <?php
    include 'partials/_dbconnect.php';
    include 'partials/_header.php';
     ?>

    
    <!-- search results -->
    <div class="container my-4" id="maincontainer">

        <h3 class="text-secondary py-3">Search result for <em>"<?php echo $_GET['search'];?>"</em></h3>
    <?php 
    $noResults = true;
    $searchElement=$_GET['search'];
        $query = "SELECT * FROM threads WHERE MATCH(thread_title,thread_desc) against('$searchElement')";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $noResults = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thId = $row['thread_id'];
            $url = "thread.php?threadId=".$thId."";

            // display search result
            echo'<div class="result">
            <h5 class="text-secondary"><a href="'.$url.'" class="text-dark">'.$title.'</a></h5>
            <p>'.$desc.'</p>
            </div>';
        }
        if ($noResults) {
            echo '<div class="jumbotron jumbotron-fluid py-5 mt-5 bg-secondary text-light" >
            <div class="container">
                <p class="display-5">No results found!</p>
                <p class="lead">Suggestions:
                <ul>
                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</li>
                    <li>Try fewer keywords.</li>
                    </p>
                </ul>
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