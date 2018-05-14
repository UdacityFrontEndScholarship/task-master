<?php require_once('db/load.php'); ?>

<?php


if(isset($_POST['change_pic'])){

  $image = $_FILES['fileToUpload']['name'];
  $image_temp = $_FILES['fileToUpload']['tmp_name'];

  $temp = explode(".", $_FILES["fileToUpload"]["name"]);

  if(isset($_POST['user_name'])){
    $user_name = $_POST['user_name'];
    $user_name .= '.' . end($temp);
    //echo $user_name;
  }

  //echo $image."</br>";
  //echo $image_temp."</br>";

  move_uploaded_file($image_temp, "../img/profile_photos/$user_name");

  $login->update_db_for_profile_pic($user_name);
  
}


?>

<?php include("profile/profile_header.php") ?>

<?php include("profile/profile_pc_navbar.php") ?>
<?php include("profile/profile_mobile_navbar.php") ?>



    <div class="container-fluid">
        <div class="row">
            <?php include("profile/profile_sidebar.php") ?>
            <?php include("profile/profile_info.php") ?>
        </div>
    </div>

<?php include("profile/profile_footer.php") ?>
