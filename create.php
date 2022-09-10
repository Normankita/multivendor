<?php
// Include config file
require_once "config.php";


// Define variables and initialize with empty values
$name = $description = $price = "";
$name_err = $description_err = $price_err = "";
$msg = $filename = $tempname = $folder = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // photo upload

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../img/" . $filename;
    // moving the uploaded image into the folder: img    
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    }
    else {
        echo "<h3>Failed to upload image!</h3>";
    }


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

    // Validate description
    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $description_err = "Please enter an description.";
    }
    else {
        $description = $input_description;
    }

    // Validate price
    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $price_err = "Please enter the price amount.";
    }
    elseif (!ctype_digit($input_price)) {
        $price_err = "Please enter a positive integer value.";
    }
    else {
        $price = $input_price;
    }


    // Check input errors before inserting in database
    if (empty($name_err) && empty($description_err) && empty($price_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, description, price, image) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_description, $param_price, $param_image);

            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_price = $price;
            $param_image = $folder;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
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
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
<?php include "sidenav.php"; ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add Product Here</h2>
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
                        <div class="form-group">
                        <select name="category" style="width: 300px;">
                            
                        
                        <!--Here goes nothing-->
                            <?php
                            $sql = "SELECT * FROM category";

                            if ($result = mysqli_query($link, $sql)) {
                            
                                if (mysqli_num_rows($result) > 0) {
                                    // echo "<br>";
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value=" . $row['category_id'] .">". $row['name'] ."</option>";
                                    }
                                }
                                else {
                                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                }
                            }
                            else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                            ?>
                            <!-- Here ends nothing -->

                            
                        </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="file" name="uploadfile" value="" />
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <textarea name="description"
                                class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $description_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Price/Unit</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback">
                                <?php echo $price_err; ?>
                            </span>
                        </div>
                        <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>