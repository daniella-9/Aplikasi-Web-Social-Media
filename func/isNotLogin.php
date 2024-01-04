<?php 
if(!isset($_SESSION['username'])) {
    $_SESSION['error'] = 'Anda Belum Login!';
	header('location: index.php');
}