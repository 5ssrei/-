<?php
session_start();

// If the user is already logged in, redirect to the home page.
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection.
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind the email parameter to the prepared statement.
    mysqli_stmt_bind_param($stmt, "s", $email);
    
    // Execute the prepared statement.
    mysqli_stmt_execute($stmt);
    
    // Get the result of the query.
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Check if user exists and password is correct.
    if ($user && password_verify($password, $user["password"])) {
        // Set session variables for the logged-in user.
        $_SESSION["user"] = "yes";
        
        // Redirect to the "hi.php" page after successful login.
        header("Location: hi.php");
        exit();
    } else {
        // Display an error message if login fails.
        echo "<div class='alert alert-danger'>Invalid email or password.</div>";
    }
    
    // Close the prepared statement.
    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>
