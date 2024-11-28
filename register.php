<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "redstore";

// 建立連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // 加密密碼

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);
    
    if ($stmt->execute() === TRUE) {
        echo "<script>alert('註冊成功!'); window.location.href = 'account.html';</script>";
    } else {
        echo "<script>alert('錯誤: " . $conn->error . "'); window.location.href = 'account.html';</script>";
    }
    $stmt->close();
}

$conn->close();
?>
