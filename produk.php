<?php
include "koneksi.php";

if (isset($_POST['upload'])) {
    $targetDir = "uploads/";
    $fileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $newName = uniqid() . "." . $fileType;
    $targetFile = $targetDir . $newName;

    // Check image validity
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if (!$check) {
        die("File is not an image.");
    }

    // Check size (optional: limit 2MB)
    if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
        die("File is too large.");
    }

    // Allow only specific formats
    $allowed = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($fileType, $allowed)) {
        die("Only JPG, JPEG, PNG, and GIF are allowed.");
    }

    // Upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO produk (filename, kategori) VALUES (?, ?)");
        $stmt->bind_param("ss", $newName, $_POST['kategori']);
        $stmt->execute();

        echo "Image uploaded and saved in database.";
        echo "<br><img src='$targetFile' width='200'>";
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Upload Image</title></head>
<body>
  <h2>Upload Image</h2>
  <form action="produk.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <br><br>
    <label for="kategori">Select Category:</label>
    <select name="kategori" id="kategori">
        <option value="kategori1">Photography</option>
        <option value="kategori2">Art</option>
    </select>
    <br><br>
    <button type="submit" name="upload">Upload</button>
  </form>
</body>
</html>
