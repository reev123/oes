<?php 
$servername="localhost";
$username="root";
$password="";
$db="oes";
$conn=mysqli_connect($servername,$username,$password,$db);

if(!$conn)
{
    die("Error");
}
if (session_status() === PHP_SESSION_NONE) 
    {session_start();
        if(!isset($_SESSION['status']))
$_SESSION['status']='';//initialising values if they haven't been initialises
if(!isset($_SESSION['email']))
$_SESSION['email']=null;
    }