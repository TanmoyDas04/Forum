<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>iDiscuss - Coding Forums</title>
    <style>
    img {
        width: 50px;
        height: 45px;
    }
    </style>
</head>

<body>
    <?php include("partials/_dbconnect.php")?>
    <?php include("partials/_header.php")?>
    <?php
    $id=$_GET["catid"];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($result)) {
        $catname=$row["category_name"];
        $catdesc=$row["category_description"];
    }
    ?>

    <?php
    $showAlert=false;
    $method= $_SERVER['REQUEST_METHOD'];
    if ($method=='POST') {
        // Insert into thread db
        $th_title=$_POST['title'];
        $th_title=str_replace("<","&lt;",$th_title);
        $th_title=str_replace(">","&gt;",$th_title);

        $th_desc=$_POST['desc'];
        $th_desc=str_replace("<","&lt;",$th_desc);
        $th_desc=str_replace(">","&gt;",$th_desc);

        $sno=$_POST['sno'];
        $sno=str_replace("<","&lt;",$sno);
        $sno=str_replace(">","&gt;",$sno);

        $sql="INSERT INTO `threads`( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title','$th_desc','$id','$sno',current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if ($showAlert) {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> You thread has been added! Please wait for community to respond.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }
    ?>

    <div class="container my-4">
        <!-- using jumbotron -->
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> Forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum is for sharing knowledge with each other. No Spam / Advertising /
                Self-promote in the forums is not allowed. Warn About Adult Content.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.
                Do Not Offer to Work For Hire.
                Do Not Post About Commercial Products.
                Do Not Create Multiple Accounts (Sockpuppets)
                When creating links to other resources.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container my-3">
            <h1>Start a Discussion</h1>
            <form action='.$_SERVER["REQUEST_URI"].' method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your as short and crisp as possible.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Ellaborate your concern</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="desc"
                        name="desc"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    }
    else {
        echo '<div class="container my-3">
        <h1>Start a Discussion</h1>
        <p class="lead">Please login to start your Discussion.</p>
        </div>';
    }
    ?>
    <div class="container my-3" style="min-height:400px;">
        <h1>Browse Questions</h1>
        <?php
    $id=$_GET["catid"];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result=mysqli_query($conn,$sql);
    $noResult=true;
    while ($row=mysqli_fetch_assoc($result)) {
        $noResult=false;
        $title=$row["thread_title"];
        $desc=$row["thread_desc"];
        $id=$row["thread_id"];
        $thread_user_id=$row["thread_user_id"];
        $sql1="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result1=mysqli_query($conn,$sql1);
        $row1=mysqli_fetch_assoc($result1);
        echo '<div class="media my-3">
        <img class="mr-3" src=https://st2.depositphotos.com/1104517/11967/v/950/depositphotos_119675554-stock-illustration-male-avatar-profile-picture-vector.jpg" alt="Generic placeholder image">
        <div class="media-body">
            <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
            '.$desc.'
            <p class="font-weight-bold my-0">Asked by: '.$row1["user_email"].'&nbsp; at &nbsp;'.$row["timestamp"].'</p>
        </div>
        </div>';
    }
    if ($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Threads Found</p>
          <p class="lead">Be the first person to ask a question</p>
        </div>
      </div>';
    }
    ?>
    </div>
    <?php include("partials/_footer.php")?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>