<?php
require_once "db.php";

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f5fa;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #234a80;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #234a80;
            color: white;
        }

        tr:nth-child(even) {
            background: #eee;
        }

        .top-link {
            display: inline-block;
            margin-bottom: 15px;
        }

        .action {
            display: inline-block;
            margin: 3px;
        }

        @media (max-width: 800px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 6px;
            }
        }
    </style>
</head>

<body>

<h2>Registered Student Records</h2>

<a class="top-link" href="index.php">Register New Student</a>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll Number</th>
        <th>Email</th>
        <th>Course</th>
        <th>File Type</th>
        <th>Upload Date</th>
        <th>Uploaded File</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["roll_number"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= htmlspecialchars($row["course"]) ?></td>

            <td>
                <?= htmlspecialchars($row["file_type"] ?? "Not uploaded") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["upload_date"] ?? "Not available") ?>
            </td>

            <td>
                <?php if (!empty($row["file_path"])): ?>
                    <a
                        href="<?= htmlspecialchars($row["file_path"]) ?>"
                        target="_blank"
                        rel="noopener"
                    >View / Download</a>
                <?php else: ?>
                    No file
                <?php endif; ?>
            </td>

            <td>
                <a
                    class="action"
                    href="edit.php?id=<?= (int)$row["id"] ?>"
                >Edit</a>

                <form
                    method="POST"
                    action="delete.php"
                    onsubmit="return confirm('Delete this student record?');"
                >
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int)$row["id"] ?>"
                    >

                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>