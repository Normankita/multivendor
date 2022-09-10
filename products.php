<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mediaQuery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Backend</title>


</head>

<body>
    <?php include "sidenav.php"; ?>

    <!-- The table begins here -->

    <div class="main">
        <div class="headerButton">
            <div style="padding: 20px;">
                <a class="btn" href="create.php"><button
                        style="background:#009F7F; color:white; padding:10px; border:5px; float:right;">
                        <span class="fa fa-plus"></span>&nbsp; Add Product</button></a>
            </div>
        </div> <br>
        <?php
// Include config file
require_once "config.php";

// Attempt select query execution
$sql = "SELECT * FROM employees";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered table-striped">';
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Image</th>";
        echo "<th>Name</th>";
        echo "<th>Price/Unit</th>";
        echo "<th>Quantity</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . "<img src= '" . $row['image'] . "' alt=''>" . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . "18" . "</td>";
            echo "<td>";
            echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        mysqli_free_result($result);
    }
    else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
}
else {
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
mysqli_close($link);
?>
        <div class="pagination" style="padding-top: 20px;">
            <a href="#">❮</a>
            <a href="#">1</a>
            <a href="#" class="active" style="color: white !important;">2</a>
            <a href="#" style="color: #1F2937 !important;">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">6</a>
            <a href="#">❯</a>
        </div>
        <br><br>
    </div>

    <script src="js/app.js" type="text/javascript">
    </script>

</body>

</html>