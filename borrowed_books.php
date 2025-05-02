<?php
include 'db.php';

// Fetch all books from the books table
$query = "SELECT * FROM books";
$result = $conn->query($query);

// Fetch all borrowed books
$borrowedQuery = "SELECT borrowed_books.id, books.title, borrowed_books.borrowed_by, borrowed_books.borrowed_date, borrowed_books.borrowed_quantity 
                  FROM borrowed_books 
                  INNER JOIN books ON borrowed_books.book_id = books.id";
$borrowedResult = $conn->query($borrowedQuery);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $borrowed_by = $_POST['borrowed_by'];
    $borrowed_date = $_POST['borrowed_date'];
    $borrowed_quantity = $_POST['borrowed_quantity'];

    // Get current book quantity
    $bookQuery = "SELECT quantity FROM books WHERE id = ?";
    $bookStmt = $conn->prepare($bookQuery);
    $bookStmt->bind_param("i", $book_id);
    $bookStmt->execute();
    $bookResult = $bookStmt->get_result();
    $book = $bookResult->fetch_assoc();
    $available_quantity = $book['quantity'];

    // Check if there are enough books to borrow
    if ($available_quantity >= $borrowed_quantity) {
        // Insert the borrowed book record
        $insert_query = "INSERT INTO borrowed_books (book_id, borrowed_by, borrowed_date, borrowed_quantity) 
                         VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("issi", $book_id, $borrowed_by, $borrowed_date, $borrowed_quantity);
        $stmt->execute();

        // Update the quantity of the book in the books table
        $update_quantity_query = "UPDATE books SET quantity = quantity - ? WHERE id = ?";
        $updateStmt = $conn->prepare($update_quantity_query);
        $updateStmt->bind_param("ii", $borrowed_quantity, $book_id);
        $updateStmt->execute();

        // Redirect after successful insertion
        header("Location: borrowed_books.php");
        exit;
    } else {
        $error_message = "Not enough books available for borrowing.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow a Book</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>

<body>
    <header>
        <h1>📚 Library Inventory</h1>
        
    </header>


    <main>
        <div class="form-container">
            <form action="borrowed_books.php" method="POST">
                <h2>Borrow a Book</h2>
                 <!-- Back button to go to the previous page -->
                <a href="admin_dashboard.php" class="back-button">← Back</a>
                <button onclick="window.location.href='borrowed_books_list.php'">See List <i class="fa-solid fa-file"></i></button>
                

                <label for="book_id">Select Book</label>
                <select name="book_id" id="book_id" required>
                    <option value="">--Select Book--</option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                    <?php endwhile; ?>
                </select><br><br>

                <label for="borrowed_by">Teacher's Name</label>
                <input type="text" name="borrowed_by" id="borrowed_by" placeholder="Teacher's Name" required><br><br>

                <label for="borrowed_date">Date Borrowed</label>
                <input type="date" name="borrowed_date" id="borrowed_date" required><br><br>

                <label for="borrowed_quantity">Quantity</label>
                <input type="number" name="borrowed_quantity" id="borrowed_quantity" min="1" required><br><br>

                <button type="submit">Submit</button>
            </form>

            <?php if (isset($error_message)): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php endif; ?>
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
        background-color: #7D0A0A;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #7D0A0A;
        color: #fff;
        text-align: center;
        padding: 10px 0;
    }

    .form-container {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        margin: 50px auto;
        margin-top: -20px;
    }

    h1 {
        font-size: 42px;
        font-weight: 600;
        margin-bottom: 30px;
        color: #ffbf00;
        text-align: center;
        margin-left: -20px;
        margin-top: 0px;
    }

    h2 {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 30px;
        color: #ffbf00;
        text-align: center;
    }

    label {
        font-size: 16px;
        margin-bottom: 10px;
        display: block;
        color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    input:focus,
    select:focus {
        border-color: #3498db;
        outline: none;
    }

    button[type="submit"] {
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

    button[type="submit"]:hover {
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
    a.btn, button {
            padding: 8px 12px;
            background-color: #ffbf00;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
            margin-bottom: 10px;
    }

    a.btn:hover, button:hover {
        background-color: #e0a800;
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
</style>
