<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nullspector_db";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تعيين الترميز
$conn->set_charset("utf8");
?>