<?php
// Include config file
require_once "config.php";


// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
$msg = $filename = $tempname = $folder = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    }
    elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    }
    else {
        $name = $input_name;
    }

    
    // Check input errors before inserting in database
    if (empty($name_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO category (name) VALUES (?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = $name;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: #");
                exit();
            }
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection


    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mediaQuery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <title>Backend</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


</head>

<body>




    <div class="wrapper" style="margin-left: 50%;">

        <!-- The Modal Body -->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="background-color: whitesmoke; width: 50%;">
                <span class="close">&times;</span>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="mt-5">Add Category</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                        class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $name; ?>">
                                    <span class="invalid-feedback">
                                        <?php echo $name_err; ?>
                                    </span>
                                </div>
                        </div>
                        <button class="btn btn-primary" type="submit" name="upload">Create</button>
                        <a href="#" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add Category</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post"
                        enctype="multipart/form-data">
                        <div class="form-group" style="display: none;">
                            <label>Name</label>
                            <input type="text" name="name"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $name_err; ?>
                            </span>
                        </div>
                </div>
                <button class="btn btn-primary" type="submit" name="upload">Create</button>
                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    </div>
  
    <?php include "sidenav.php"; ?>

    <!-- The table begins here -->

    <div class="main">
        <div class="headerButton">
            <div style="padding: 20px;"><button  onclick="buttonFunction()"
                        style="background:#009F7F; color:white; padding:10px; border:5px; float:right;">
                        <span class="fa fa-plus"></span>&nbsp; Add Category</button>
            </div>
        </div> <br>
        <?php
// Include config file
require_once "config.php";

// Attempt select query execution
$sql = "SELECT * FROM category";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered table-striped">';
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Name</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['category_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>";
            echo '<a href="read.php?id=' . $row['category_id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<a href="update.php?id=' . $row['category_id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<a href="delete.php?id=' . $row['category_id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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


    <script>

        function buttonFunction(){
            modal.style.display = "block";
        }
        // Get the modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script src="js/app.js" type="text/javascript">
    </script>

</body>

</html>