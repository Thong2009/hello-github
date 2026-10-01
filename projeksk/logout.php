<?php
include('inc_header.php');

session_destroy();

echo"<script>alert('Log keluar berjaya.');window.location.replace('index.php');</script>";
?>