<?php 
session_start();
$servername= "localhost";
$username = "root";
$password = "";
$dbname="ShopEase";

$conn = mysqli_connect("localhost","root","","ShopEase")
        or die("could'nt connect to the database");
