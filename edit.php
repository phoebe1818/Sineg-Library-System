<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get current book data
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found!";
    exit;
}

// Update on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $year = $_POST['year'] ?? 0;
    $type = $_POST['type'] ?? '';

    $update = $conn->prepare("UPDATE books SET title=?, author=?, year=?, type=? WHERE id=?");
    $update->bind_param("ssisi", $title, $author, $year, $type, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #7d0a0a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-wrapper {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .form-wrapper h1 {
            margin-bottom: 20px;
            color: #7d0a0a;
        }

        .form-wrapper input[type="text"],
        .form-wrapper input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .form-wrapper button {
            width: 100%;
            padding: 12px;
            background-color: #ffbf00;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .form-wrapper a {
            display: inline-block;
            margin-top: 10px;
            color: #7d0a0a;
            text-decoration: none;
        }
        .back-button {
            display: inline-block;
            padding: 10px 16px;
            background-color: #ffbf00;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #e0a800;
        }

    </style>
</head>
<body>
    <div class="form-wrapper">
    <a href="index.php" class="back-button">← Back to list</a>
        <h1>Edit Book</h1>
        <form method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
            <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>" required>
            <input type="text" name="type" value="<?= htmlspecialchars($book['type']) ?>" required>
            <button type="submit">Update Book</button>
        </form>
       
    </div>
</body>
</html>
