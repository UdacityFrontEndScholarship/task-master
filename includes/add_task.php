<?php

//echo "Add_USer.php";

require_once('db/load.php');

// Handle logins
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $adduser_status = $login->add_task($_POST);

    if($adduser_status['status']){
      redirect( 'profile.php' );
    }
}
