<?php
include 'db.php'; // Ensure this sets up $conn properly

// Pagination setup
$limit = 10; // Books per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total books count
$totalBooksResult = $conn->query("SELECT COUNT(*) AS total FROM books");
$totalBooks = $totalBooksResult ? $totalBooksResult->fetch_assoc()['total'] : 0;
$totalPages = ceil($totalBooks / $limit);

// Fetch books for current page
$result = $conn->query("SELECT * FROM books ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<header>
    <div class="logo-container">
        <img src="http://localhost/Sineg_LibrarySystem/image/logo.png" alt="Library Logo" class="logo">
        <h1>Library Book List</h1>
    </div>
</header>

<nav>
    <ul class="nav-links">
        <li><a href="admin_dashboard.php"><i class="fa-solid fa-house"></i></a></li>
        <li><a href="add.php"><i class="fa-solid fa-book"></i></a></li>
    </ul>
</nav>

<main>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['author']) ?></td>
                    <td><?= htmlspecialchars($row['year']) ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a> |
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this book?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>&copy; SHS within Sineguelasan Elementary School Library System 2025</p>
</footer>

<style>
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

</body>
</html>
