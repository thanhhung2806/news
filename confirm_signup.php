<?php
// connect database 
$con;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "NguyenThanhHung_ASM";

$con = mysqli_connect($servername, $username, $password);
mysqli_select_db($con, $dbname);
mysqli_query($con, "SET NAMES 'utf8'");

// giá trị lấy từ form

$userName = $_POST["userName"];
$passWord = $_POST["passWord"];
$maSV = $_POST["maSV"];
$ten = $_POST["ten"];
$email = $_POST["email"];
$gioiTinh = $_POST["gioiTinh"];
$soThich = $_POST["soThich"];
$tinhThanh = $_POST["tinhThanh"];
$ghiChu = $_POST["ghiChu"];
// select maSV
$qr = "SELECT maSV FROM thanhvien";
$rows = mysqli_query($con, $qr);

// Kiểm tra button thực hiện submit
if (isset($_POST["btn-add"])) {
    $btnSubmit = "ADD";
} else if (isset($_POST["btn-update"])) {
    $btnSubmit = "UPDATE";
} else {
    $btnSubmit = "DELETE";
}
// kiểm tra maSV có tồn tại trong datase hay chưa
$result = false;
foreach ($rows as $item) {
    if ($_POST["maSV"] == $item["maSV"]) {
        $result = true;
    }
}
$text = $result === true ? "true" : "false";

switch ($btnSubmit) {
    case "ADD":
        try {
            if ($result) {
                $thongbao =  "đã tồn tại người dùng này";
                require_once(realpath(dirname(__FILE__) . '/notify.html'));
                // echo "đã tồn tại người dùng này";
            } else {
                $qr = "INSERT INTO thanhvien VALUES ('$userName','$passWord',$maSV,'$ten','$email','$gioiTinh','$soThich','$tinhThanh','$ghiChu')";
                mysqli_query($con, $qr);
                $thongbao = "Bạn đã đăng kí thành công";
                require_once(realpath(dirname(__FILE__) . '/notify.html'));
            }
        } catch (PDOException $e) {
            echo "lỗi";
        }
        break;
    case "UPDATE":
        try {
            if (!$result) {
                $thongbao = "không tồn tại người dùng này";
                require_once(realpath(dirname(__FILE__) . '/notify.html'));
            } else {
                $qr = "UPDATE thanhvien SET ten = '$ten', email = '$email' WHERE maSV = $maSV";
                mysqli_query($con, $qr);
                if (mysqli_query($con, $qr)) {
                    $thongbao = "chỉnh sửa thành công";
                    require_once(realpath(dirname(__FILE__) . '/notify.html'));
                } else {
                    $thongbao = "chỉnh sửa không thành công";
                    require_once(realpath(dirname(__FILE__) . '/notify.html'));
                }
            }
        } catch (PDOException $e) {
            echo "lỗi";
        }
        break;
    case "DELETE":
        try {
            if (!$result) {
                $thongbao = "không tồn tại người dùng này";
                require_once(realpath(dirname(__FILE__) . '/notify.html'));
            } else {
                $maSV = $_POST["maSV"];

                $qr = "DELETE FROM thanhvien WHERE maSV = $maSV";
                mysqli_query($con, $qr);
                if (mysqli_query($con, $qr)) {
                    $thongbao = "xóa người dùng thành công";
                    require_once(realpath(dirname(__FILE__) . '/notify.html'));
                } else {
                    $thongbao = "xóa không thành công";
                    require_once(realpath(dirname(__FILE__) . '/notify.html'));
                }
            }
        } catch (PDOException $e) {
            echo "lỗi";
        }
        break;
}
