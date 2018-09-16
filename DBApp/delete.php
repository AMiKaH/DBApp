<?php

$id = $_GET['id'];
//Connect DB
//Create query based on the ID passed from you table
//query : delete where id = $id
// on success delete : redirect the page to original page using header() method

include "conn.php";
// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql query to delete a record
$del = "DELETE FROM orders WHERE id = $id"; 

if (mysqli_query($connection, $del)) {
    mysqli_close($connection);
    header('Location: db.php'); 
    exit;
} else {
    echo "Error deleting record";
}

?>