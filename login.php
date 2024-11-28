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
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE full_name=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            echo "<script>alert('您已登入成功😀'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('密碼錯誤!'); window.location.href = 'account.html';</script>";
        }
    } else {
        echo "<script>alert('用戶不存在!'); window.location.href = 'account.html';</script>";
    }
    $stmt->close();
}

$conn->close();
?>
