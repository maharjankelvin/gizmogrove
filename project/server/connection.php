<?php 
session_start();
$servername= "localhost";
$username = "root";
$password = "";
$dbname="gizmogrove";

$conn = mysqli_connect("localhost","root","","gizmogrove")
        or die("could'nt connect to the database");
