<?php

  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>
<?php
// initializing variables



$iddangkyungho = $_GET['id'];

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'quanlylulut');
if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


    // if ($result -> num_rows >  0) {
                                       
    //     while ($row = $result->fetch_assoc()) 

    $user = $_SESSION['username'];
  
       $sql1 = "SELECT * FROM nhanvien WHERE tenTaiKhoan = '$user'";
       $result1 = mysqli_query($db,$sql1);
       $row1 = mysqli_fetch_array($result1);
       $idnhanvien = $row1['idNhanVien'];

       date_default_timezone_set('Asia/Ho_Chi_Minh');

       $date = getdate();
       $ngayNhap = date("Y-m-d ");

       $sql_phieunhap = "INSERT INTO phieunhap (idDangKyUngHo ,idNhanVien, ngayNhap)
        VALUES ('$iddangkyungho','$idnhanvien','$ngayNhap')";

        $result_phieunhap = mysqli_query($db,$sql_phieunhap);

        if($result_phieunhap){
            $sql2 = "SELECT * FROM phieunhap ORDER BY idPhieuNhap DESC LIMIT 1";
            $result2 = mysqli_query($db,$sql2);
            $row2 = mysqli_fetch_array($result2);
            $idphieunhap = $row2['idPhieuNhap'];

            $sql3 = "SELECT * FROM chitietdangkyungho WHERE idDangKyUngHo = '$iddangkyungho'";
            $result3 = mysqli_query($db,$sql3);
             if ($result3 -> num_rows >  0) {
                                       
             while ($row3 = $result3->fetch_assoc()) {
                $idhangcuutro = $row3['idHangCuuTro'];
                $soluong = $row3['soLuong'];
                $sql_ctpn = "INSERT INTO `chitietphieunhap`(idPhieuNhap, idHangCuuTro, soLuong) 
                VALUES ('$idphieunhap','$idhangcuutro','$soluong')";
                $result_ctpn = mysqli_query($db,$sql_ctpn);
             }
            }
            $sql_status = "UPDATE dangkyungho SET trangThai=1 WHERE idDangKyUngHo = '$iddangkyungho'";
            $result_status = mysqli_query($db,$sql_status);

        }

        
        header("location: show_dangkiungho.php");


?>