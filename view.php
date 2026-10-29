
<?php
include 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : ''; 
$sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR email LIKE 
'%$search%' ORDER BY id DESC"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>View Students - Students Information System</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
rel="stylesheet"> 
</head> 
<body> 
<div class="container mt-5"> 
<h2>All Students</h2> 
<form method="GET" class="mb-3"> 
<input type="text" name="search" class="form-control" placeholder="Search by Name or 
Email" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>"> 
</form> 
<table class="table table-bordered table-striped"> 
<thead> 
<tr> 
<th>ID</th> 
<th>Name</th> 
<th>Email</th> 
<th>Phone</th> 
<th>Created At</th> 
</tr> 
</thead> 
<tbody> 
<?php 
if ($result->num_rows > 0) { 
while($row = $result->fetch_assoc()) { 

?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>
        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>

        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure?');">Delete</a>
    </td>
</tr>
<?php

} 
} else { 
echo "<tr><td colspan='5'>No entries found</td></tr>"; 
} 
?> 
</tbody> 
</table> 
</div> 
</body> 
</html>