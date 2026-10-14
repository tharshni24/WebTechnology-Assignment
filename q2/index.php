<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $roll_number = trim($_POST["roll_number"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");

    $file_path = null;
    $file_type = null;
    $saved_file = null;

    if ($name === "" || $roll_number === "" || $course === "") {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else {
        $upload_error = $_FILES["student_file"]["error"]
            ?? UPLOAD_ERR_NO_FILE;

        if ($upload_error !== UPLOAD_ERR_NO_FILE) {
            if ($upload_error !== UPLOAD_ERR_OK) {
                $message = "File upload failed.";
            } elseif ($_FILES["student_file"]["size"] > 2 * 1024 * 1024) {
                $message = "File size must not exceed 2 MB.";
            } else {
                $allowed_types = [
                    "application/pdf" => ".pdf",
                    "image/jpeg" => ".jpg",
                    "image/png" => ".png"
                ];

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $detected_type = $finfo->file(
                    $_FILES["student_file"]["tmp_name"]
                );

                if (!isset($allowed_types[$detected_type])) {
                    $message = "Only PDF, JPG, and PNG files are allowed.";
                } else {
                    $upload_dir = __DIR__ . "/uploads/";

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    $unique_name = bin2hex(random_bytes(16))
                        . $allowed_types[$detected_type];

                    $destination = $upload_dir . $unique_name;

                    if (move_uploaded_file(
                        $_FILES["student_file"]["tmp_name"],
                        $destination
                    )) {
                        $saved_file = $destination;
                        $file_path = "uploads/" . $unique_name;
                        $file_type = $detected_type;
                    } else {
                        $message = "Unable to save the uploaded file.";
                    }
                }
            }
        }

        if ($message === "") {
            try {
                $stmt = $conn->prepare(
                    "INSERT INTO students
                    (name, roll_number, email, course, file_path, file_type)
                    VALUES (?, ?, ?, ?, ?, ?)"
                );

                $stmt->bind_param(
                    "ssssss",
                    $name,
                    $roll_number,
                    $email,
                    $course,
                    $file_path,
                    $file_type
                );

                $stmt->execute();
                $stmt->close();

                $message = "Student registered successfully!";
            } catch (mysqli_sql_exception $e) {
                if ($saved_file && file_exists($saved_file)) {
                    unlink($saved_file);
                }

                if ($e->getCode() == 1062) {
                    $message = "This roll number is already registered.";
                } else {
                    $message = "Registration failed. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f5fa;
            padding: 25px;
        }

        .container {
            max-width: 450px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #234a80;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            color: white;
            background: #234a80;
            border: none;
            cursor: pointer;
        }

        .message {
            text-align: center;
            color: green;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Student Registration</h2>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="name">Student Name</label>
        <input type="text" id="name" name="name" required>

        <label for="roll_number">Roll Number</label>
        <input type="text" id="roll_number" name="roll_number" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="course">Course</label>
        <input type="text" id="course" name="course" required>

        <label for="student_file">Upload File (PDF, JPG, PNG; max 2 MB)</label>
        <input
            type="file"
            id="student_file"
            name="student_file"
            accept=".pdf,.jpg,.jpeg,.png"
        >

        <button type="submit">Register Student</button>
    </form>

    <a href="view.php">View Student Records</a>
</div>
</body>
</html>