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

<!-- Mobile-friendly Navigation Bar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="index.html">
            Students Information System
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="form.html">Form</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="view.php">View Students</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- Responsive Container -->

<div class="container-fluid mt-5">

<h2>All Students</h2>

<form method="GET" class="mb-3">

<input type="text" name="search" class="form-control"
placeholder="Search by Name or Email"
value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">

</form>


<!-- Bootstrap Row and Column -->

<div class="row">

    <div class="col-md-6 col-lg-12">

        <!-- Responsive Table -->

        <div class="table-responsive">

<table class="table table-bordered table-striped" id="entriesTable">

<thead>

<tr>

<th>ID</th>

<th onclick="sortTable(1)" style="cursor:pointer;">Name</th>

<th onclick="sortTable(2)" style="cursor:pointer;">Email</th>

<th onclick="sortTable(3)" style="cursor:pointer;">Phone</th>

<th>Created At</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if ($result->num_rows > 0) {

while($row = $result->fetch_assoc()) {

?>

<tr onmouseover="this.style.backgroundColor='#f2f2f2'"
    onmouseout="this.style.backgroundColor=''">

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a href="update.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">Edit</a>

<!-- Button trigger modal -->

<button type="button" class="btn btn-danger"
data-bs-toggle="modal"
data-bs-target="#deleteModal<?php echo $row['id']; ?>">

Delete

</button>

<!-- Modal -->

<div class="modal fade"
id="deleteModal<?php echo $row['id']; ?>"
tabindex="-1" aria-hidden="true">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">Confirm Delete</h5>

<button type="button" class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

Are you sure you want to delete this entry?

</div>

<div class="modal-footer">

<a href="delete.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger">Yes, Delete</a>

<button type="button" class="btn btn-secondary"
data-bs-dismiss="modal">Cancel</button>

</div>

</div>

</div>

</div>

</td>

</tr>

<?php

}

} else {

echo "<tr><td colspan='6'>No entries found</td></tr>";

}

?>

</tbody>

</table>

        </div>

    </div>

</div>

</div>


<!-- JavaScript Table Sorting -->

<script>

function sortTable(n) {

    let table, rows, switching, i, x, y, shouldSwitch;

    table = document.getElementById("entriesTable");

    switching = true;

    while (switching) {

        switching = false;

        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {

            shouldSwitch = false;

            x = rows[i].getElementsByTagName("TD")[n];

            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

                shouldSwitch = true;

                break;

            }

        }

        if (shouldSwitch) {

            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);

            switching = true;

        }

    }

}

</script>


<!-- Bootstrap JavaScript -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>