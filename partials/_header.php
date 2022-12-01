<?php

    echo ' <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">SFORUM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Catagories
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
            // to fetch categories for dropdown
              $sql= "SELECT category_name, category_id FROM `categories` LIMIT 4";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result)){
                $catName = $row['category_name'];
                $catId = $row['category_id'];
                echo'<li><a class="dropdown-item" href="threads.php?catid='.$catId.'">'.$catName.'</a></li>';
              }

              echo'
              <li><a class="dropdown-item" href="#">More Categories</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-flex mx-2">
        <form class="d-flex" action="search.php" method="get">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
        </form>';
        session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
   echo  '
    <p class="text-light mb-0 mt-2 mx-2">Welcome '.$_SESSION['username'].'</p>
    <a class="text-decoration-none" href="partials/_logout.php">
    <button class="btn btn-outline-warning ml-2">Logout</button>
    </a>';
  }
  else {
    
     echo '<button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
     ';
  }
  echo'</div>
  </div>
  </div>
  </nav>';
  include "partials/_loginModal.php";
  include "partials/_signupModal.php";

       
  // <!-- 🙌🙌signup Alert section starts here🙌🙌 -->
  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=='true') {
     
      $signup=$_GET['signupsuccess'];
      echo'<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
         <strong>Success!</strong> Your account is created now you can login.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
      
      
  }
  if (isset($_GET['error'])) {
    $error=$_GET['error'];
    echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
         <strong>ERROR!</strong> '.$error.'.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
 }
  // <!-- 🙌🙌Login success Alert🙌🙌 -->
  if (isset($_GET['loginsuccess']) && $_GET['loginsuccess']=='true') {
     
    $signup=$_GET['loginsuccess'];
    echo'<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
       <strong>SUCCESS!</strong> You are successfully logged in.
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
  // <!-- 🙌🙌Logout success Alert🙌🙌 -->
  if (isset($_GET['logoutsuccess']) && $_GET['logoutsuccess']=='true') {
     
    
    echo'<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
       You are <strong>LOGGED OUT!</strong> 
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
?>