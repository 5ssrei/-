<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           // Validate inputs
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors, "All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
           }
           if ($password !== $passwordRepeat) {
            array_push($errors, "Passwords do not match");
           }

           // Check if email already exists
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = ?";
           $stmt = mysqli_stmt_init($conn);
           if (mysqli_stmt_prepare($stmt, $sql)) {
               mysqli_stmt_bind_param($stmt, "s", $email);
               mysqli_stmt_execute($stmt);
               $result = mysqli_stmt_get_result($stmt);
               if (mysqli_num_rows($result) > 0) {
                   array_push($errors, "Email already exists!");
               }
           } else {
               array_push($errors, "Database error: Could not check email");
           }

           // Display errors if any
           if (count($errors) > 0) {
               foreach ($errors as $error) {
                   echo "<div class='alert alert-danger'>$error</div>";
               }
           } else {
               // Insert user into database if no errors
               $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
               if (mysqli_stmt_prepare($stmt, $sql)) {
                   mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                   if (mysqli_stmt_execute($stmt)) {
                       echo "<div class='alert alert-success'>You are registered successfully. <a href='login.php'>Login Here</a></div>";
                   } else {
                       echo "<div class='alert alert-danger'>Something went wrong during registration. Please try again.</div>";
                   }
               } else {
                   echo "<div class='alert alert-danger'>Database error: Could not register user</div>";
               }
           }
        }
        ?>

        <!-- Registration Form -->
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" value="<?php echo isset($fullName) ? $fullName : ''; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" value="<?php echo isset($email) ? $email : ''; ?>">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <div>
            <p>Already Registered? <a href="login.php">Login Here</a></p>
        </div>
    </div>
</body>
</html>
