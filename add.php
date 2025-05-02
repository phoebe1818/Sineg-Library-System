<?php include 'db.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];
    $conn->query("INSERT INTO books (title, author, year) VALUES ('$title', '$author', $year)");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <!-- Google Font: Poppins -->
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
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .form-wrapper h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #7d0a0a;
        }

        .form-wrapper input[type="text"],
        .form-wrapper input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-wrapper input:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-wrapper button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ffbf00;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-wrapper button:hover {
            background-color: #2980b9;
        }

        .back-button {
            position: absolute;
            left: 20px;
            top: 20px;
            text-decoration: none;
            background-color: #ffbf00;
            color: #7d0a0a;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #ffe066;
        }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <a href="index.php" class="back-button">← Back</a>
        <h1>Add New Book</h1>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="number" name="year" placeholder="Year Published" required>
            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
