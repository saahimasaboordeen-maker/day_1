<?php 
include 'config.php'; 
if(isset($_GET['id'])){ 
$id = $_GET['id']; 
$sql = "DELETE FROM students WHERE id=$id"; 
if($conn->query($sql) === TRUE){ 
header("Location: view.php"); // redirect back to view 
} else { 
echo "Error deleting record: " . $conn->error; 
} 
} 
?>