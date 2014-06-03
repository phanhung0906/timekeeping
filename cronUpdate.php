<?php
$ch = curl_init("http://atmarkcafe.local/site/cronupdate");

// khai báo curl có kèm url
// tức đã set luôn CURLOPT_URL cho curl

if (! $ch) {
    die( "Lỗi trong quá trình khởi tạo cURL" );
}

// Chúng ta sẽ nhận trị trả về và nhận dưới dạng binary
// Dó đó ta phải set 2 option như sau

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

// Nếu không set như trên, bạn sẽ không nhận được gì
// khi curl được thực thi, tức giá trị NULL

// Chạy curl và lưu trị trả về vào $data
$data = curl_exec($ch);

// đóng kết nối
curl_close($ch);