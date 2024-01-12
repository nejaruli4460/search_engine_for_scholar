<?php
session_start();
include("connection.php");
$res=null;
if(isset($_GET["submit"])){
    $key=$_GET["search_key"];
    if(isset($_SESSION['name'])){
      $email=$_SESSION['email'];
      $sql="insert into history(tag,email) values('$key','$email')";
      $res=mysqli_query($con,$sql);      
    }
    $sql="SELECT * FROM articles where title like '%$key%' or tag like '%$key%' or Description like '%$key%' or link like '%$key%' or author_name like '%$key%'";
    $res=mysqli_query($con,$sql);
    $row=mysqli_num_rows($res);
   
}
if(isset($_GET["sub"])){
  $key=$_GET["search_key"];
  $order=null;
  $filter=null;
  $sql="SELECT * FROM articles where (title like '%$key%' or tag like '%$key%' or Description like '%$key%' or link like '%$key%' or author_name like '%$key%')";
  if($_GET["filter"]!=""){
    $filter=$_GET["filter"];
    $sql=$sql."and author_name='$filter'";
  }
  if($_GET["sortby"]!=""){
    $order=$_GET["sortby"];
    $sql=$sql." order by title $order";
  }
  
  $res=mysqli_query($con,$sql);
  $row=mysqli_num_rows($res);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./Assets/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="index.php">
                <img src="./Assets/logo.png" alt="Logo" width="55" height="30">
                NextScholar
            </a>
            <ul class = "signupLoginList">
            <?php
              if(isset($_SESSION['name'])){
            ?>
            <li><a class="nav-link" href="profile.php"><?php
            echo $_SESSION['name'];
            ?>
            </a></li>
            <?php
              }else{
            ?>
            <li><a class="nav-link" href="logIn.php">Login</a></li>
            <?php
              }
            ?>
          </ul>
        </div>
    </nav>
  
<form action="" method="get">
<input type="text" name="search_key" id=""class="input_section i-section" required value=<?php echo $_GET["search_key"]; 
 
?>>
<input type="submit" value="Search" name="sub" id="" class="search_button s-btn">
<div class="result-header">
      <div>
        <?php
          echo $row." results found";  
        ?>
      </div>

      <div class="sortby">
        <label for="sortby">Sort By</label>
        <select name="sortby" id="">
          <option value="">Select</option>
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
      </div>

      <div class="filter">
        <label for="filter">Filter</label>
        <?php
        $sql="select author_name from articles";
        $response=mysqli_query($con,$sql);

        ?>
        <select name="filter" id="">
          <option value="">Select Author Name</option>
          <?php
          while($result=mysqli_fetch_array($response)){
          ?>
          
          <option value=<?php echo $result['author_name']; ?>><?php echo $result['author_name']; ?></option>
           <?php
               }
           ?>

       on>

        </select>
      </div>

</form>
  

    </div>
    <?php
      while($result=mysqli_fetch_array($res)){
    ?>
    <div class="card">
      <h5 class="card-header">Title :<?php echo $result['title']; ?></h5>
      <div class="card-body">
        <h5 class="card-title">Author Name :<?php echo $result['author_name']; ?></h5>
        <p class="card-text text-success">Description :<?php echo $result['description']; ?></p>
        <a href=<?php  echo $result['link']; ?> class="btn btn-primary">Visit For More Details</a>
        <?php
        if(isset($_SESSION['name'])){
        ?>
        <form action="saved.php?id=<?php echo $result['article_id'];  ?>" method="post">
        <input type="submit" name="save" value='Save Article' id="">
        </form>
        <?php
        }
        ?>
      </div>
    </div>
    
    <?php
   
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>