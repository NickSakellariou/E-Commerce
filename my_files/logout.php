<?php
session_start();

unset($_SESSION['username']);
unset($_SESSION['admin']);
	
echo "<script>
window.location.href='home_page.php';
</script>";
?>