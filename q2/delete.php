<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("Invalid student ID.");
}

// Get the uploaded file path before deleting the record.
$stmt = $conn->prepare("SELECT file_path FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: view.php");
    exit;
}

// Delete the database record.
$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Delete only files located inside this project's uploads folder.
if (!empty($student["file_path"])) {
    $filename = basename($student["file_path"]);
    $upload_dir = realpath(__DIR__ . "/uploads");
    $file = $upload_dir ? $upload_dir . DIRECTORY_SEPARATOR . $filename : "";

    if (
        $upload_dir &&
        strpos($student["file_path"], "uploads/") === 0 &&
        is_file($file) &&
        realpath($file) &&
        strpos(realpath($file), $upload_dir . DIRECTORY_SEPARATOR) === 0
    ) {
        unlink($file);
    }
}

header("Location: view.php");
exit;
?>