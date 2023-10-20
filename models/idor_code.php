<?php

//hàm thêm 3 kí tự random sau id
function generateRandomString($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
//  mã hóa id
function encodeID($originalID) {
    // Mã hóa ID
    $encodedID = base64_encode($originalID);

    // Tạo một chuỗi ngẫu nhiên
    $randomPart = generateRandomString();

    // Kết hợp ID mã hóa và chuỗi ngẫu nhiên
    $finalID = $encodedID . $randomPart;

    return $finalID;
}
// giải mã id
function decodeID($encodedID) {
    // Tìm vị trí cắt
    $cutPosition = strlen($encodedID) - 3;

    // Trích xuất ID đã mã hóa
    $originalID = substr($encodedID, 0, $cutPosition);
    // $kq = base64_decode($originalID);
    if (is_numeric(base64_decode($originalID))) {
        $kq = (int) base64_decode($originalID); // Ép kiểu thành số nguyên nếu cần
    } else {
        $kq = -1;
    }
    return $kq ;
}
?>