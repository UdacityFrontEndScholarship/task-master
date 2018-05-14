<?php 
require_once('load.php'); 

// Handle registration
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $register_status = $login->register($_POST);
}
?>

<?php include('header.php'); ?>
<div class="wrapper">
    <form action="" method="post">
        <h1 class="text-center">Register</h1>
        <?php if ( isset( $register_status ) ) : ?>
        <?php ($register_status['status'] == true ? $class = 'success' : $class = 'error'); ?>
        <div class="message <?php echo $class; ?>">
            <p><?php echo $register_status['message']; ?></p>
        </div>
        <?php endif; ?>
        <input type="text" class="text" name="name" placeholder="Enter your full name" required>
        <input type="email" class="text" name="email" placeholder="Enter your email address" required>
        <input type="text" class="text" name="username" placeholder="Enter username" required>
        <input type="password" class="text" name="password" placeholder="Enter password" required>
        <input type="submit" class="submit" value="Submit">
    </form>
    <p><a href="index.php">Login here</a></p>
</div>
<?php include('footer.php'); ?>