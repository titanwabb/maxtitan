<?php
// مسیر پوشه آپلود را مشخص کنید.  این مسیر باید روی سرور شما قابل نوشتن باشد.
$uploadDir = 'uploads/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"])) {
        $file = $_FILES["image"];
        $fileName = basename($file["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $tempFilePath = $file["tmp_name"];
        $targetFilePath = $uploadDir . $fileName;

        // بررسی نوع فایل
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "نوع فایل مجاز نیست.";
            exit;
        }

        // بررسی اندازه فایل (اختیاری)
        $maxSize = 5 * 1024 * 1024; // 5 مگابایت
        if ($file["size"] > $maxSize) {
            echo "اندازه فایل بیش از حد مجاز است.";
            exit;
        }

        // جابجایی فایل به مسیر مقصد
        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
            $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $targetFilePath; // لینک عکس
            echo "عکس با موفقیت آپلود شد.<br>";
            echo "لینک عکس: <a href='$imageUrl' target='_blank'>$imageUrl</a>";
        } else {
            echo "خطا در آپلود عکس.";
        }
    } else {
        echo "لطفا یک عکس انتخاب کنید.";
    }
}
?>
