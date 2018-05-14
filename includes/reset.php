<?php require_once('load.php'); ?>
<?php include('header.php'); ?>
<div class="wrapper">
    <h1 class="text-center">Reset Password</h1>
<?php
// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');

if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) :
?>
    <form action="reset_process.php" method="post">
        <?php if ( isset( $status ) ) : ?>
        <?php ($status['status'] == true ? $class = 'success' : $class = 'error'); ?>
        <div class="message <?php echo $class; ?>">
            <p><?php echo $status['message']; ?></p>
        </div>
        <?php endif; ?>
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" class="text" name="password" placeholder="Enter your new password" required>
        <input type="submit" class="submit" value="Submit">
    </form>
    <p><a href="index.php">Login here</a></p>
<?php else : ?>
    <div class="message error">
        <p>There was an error process your password reset request. Try requesting another request <a href="lostpassword.php">here</a>.</p>
    </div>
<?php endif; ?>
</div>
<?php include('footer.php'); ?>