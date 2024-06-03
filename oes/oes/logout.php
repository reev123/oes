<?php 
include "connection.php";
session_destroy();
Header("location:homepage.php");