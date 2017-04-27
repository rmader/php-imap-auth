<?php
session_start();
if(!isset($_SESSION['userid'])) http_response_code(401);
?>
