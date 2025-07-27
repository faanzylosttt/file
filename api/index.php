<?php
$uploadDir = __DIR__ . '/../uploads';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'] ?? null;
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $ext   = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $name  = bin2hex(random_bytes(8)) . '.' . $ext;
        move_uploaded_file($file['tmp_name'], "$uploadDir/$name");
        $link  = "https://" . $_SERVER['HTTP_HOST'] . "/uploads/$name";
        echo json_encode(['url' => $link]);
        exit;
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/><title>Host File Vercel</title>
<style>body{font-family:sans-serif;padding:40px;background:#f5f7fa}input,button{font-size:16px;padding:8px 12px}</style>
</head>
<body>
<h2>Upload File & Dapatkan Link</h2>
<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="file" required>
  <button type="submit">Upload</button>
</form>
<hr>
<h3>Preview file yang sudah di-upload:</h3>
<?php
$files = array_diff(scandir($uploadDir), ['.', '..']);
foreach ($files as $f) {
    $url = "/uploads/$f";
    echo "<a href='$url' target='_blank'>$f</a><br>";
}
?>
</body>
</html>
