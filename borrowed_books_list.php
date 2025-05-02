<?php
include 'db.php';

// Fetch borrowed books and their associated book titles
$query = "
    SELECT bb.borrowed_by, bb.borrowed_date, bb.borrowed_quantity, b.title
    FROM borrowed_books bb
    JOIN books b ON bb.book_id = b.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrowed Books List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>📚 Borrowed Books</h1>
        <a href="borrowed_books.php" class="back-button">← Back</a>
    </header>

    <main>
        <div class="borrowed-books-container">
            <h2>List of Borrowed Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrowed By</th>
                        <th>Borrowed Date</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($borrowed = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($borrowed['title']) ?></td>
                            <td><?= htmlspecialchars($borrowed['borrowed_by']) ?></td>
                            <td><?= htmlspecialchars($borrowed['borrowed_date']) ?></td>
                            <td><?= htmlspecialchars($borrowed['borrowed_quantity']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; SHS within Sineguelasan Elementary School Library System 2025</p>
    </footer>
</body>
</html>
<style>
      
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #7d0a0a;
            color: black;
            margin: 0;
            padding: 0;
        }   
        h1 {
            color: #ffbd00;
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: center;
            margin-left: -20px;
        }

        h2 {
            color: #ffbd00;
            margin-bottom: 20px;
            text-align: left;
        }
        .borrowed-books-container {
            margin-top: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .borrowed-books-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .borrowed-books-container th, .borrowed-books-container td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .borrowed-books-container th {
            background-color: #EA7300;
        }

        footer {
            background-color: #7D0A0A; /* Red background */
            color: #fff; /* White text */
            text-align: center; /* Center the text */
            padding: 20px; /* Added padding for better spacing */
            margin-top: 20px;
            font-family: 'Arial', sans-serif; /* You can change this font-family if desired */
            border-top: 5px solid #fff; /* Added white border on top to separate from the content above */
        }

        footer p {
            font-size: 16px; /* Slightly larger text */
            margin: 0; /* Remove margin from the paragraph */
        }

        footer a {
            color: #fff; /* White links */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Make links bold */
        }

        footer a:hover {
            color: #FFBF00; /* Change to yellow on hover */
            text-decoration: underline; /* Add underline when hovering */
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