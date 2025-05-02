<?php
include 'db.php';

// Get book statistics
$totalBooks = $conn->query("SELECT COUNT(*) AS count FROM books")->fetch_assoc()['count'];
$textbookCount = $conn->query("SELECT COUNT(*) AS count FROM books WHERE type = 'Textbook'")->fetch_assoc()['count'];
$referenceCount = $conn->query("SELECT COUNT(*) AS count FROM books WHERE type = 'Reference'")->fetch_assoc()['count'];

// Get latest 5 books
$latestBooks = $conn->query("SELECT * FROM books ORDER BY id DESC LIMIT 5");

// Initialize counts for 2023–2025
$yearlyCounts = [
    '2023' => 0,
    '2024' => 0,
    '2025' => 0,
];

// Query to count books per year
$yearQuery = $conn->query("SELECT year, COUNT(*) as count FROM books WHERE year IN (2023, 2024, 2025) GROUP BY year");

while ($row = $yearQuery->fetch_assoc()) {
    $year = $row['year'];
    if (isset($yearlyCounts[$year])) {
        $yearlyCounts[$year] = (int)$row['count'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Your custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            background-color: #7d0a00;
        }
        h1 {
            color: #ffbd00;
            margin-top: -10px; 
            margin-bottom: 20px; 
            margin-left: 35%;
        }
        h2 {
            color: #ffbd00;
            margin-bottom: 20px; 
        }
        h3 {
            color: #ffbd00;
            margin-bottom: 30px; 
            font-size: 24px;
        }

        .dashboard-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            flex: 1;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        table th {
            background-color: #EA7300;
            color: white;
        }
        .actions {
            margin-top: 20px;
        }
        .actions button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            background-color: #ffbd00;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        .logout-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .logout-button {
            background-color: #ffbd00;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .logout-button i {
            margin-right: 5px;
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
</head>
<body>

<div class="logout-container">
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>

<h1>📚 Library Dashboard</h1>

<div class="dashboard-cards">
    <div class="card">Total Books: <?= $totalBooks ?></div>
    <div class="card">Textbooks: <?= $textbookCount ?></div>
    <div class="card">References: <?= $referenceCount ?></div>
</div>

<h2>📖 Recently Added Books</h2>
<table>
    <thead>
        <tr>
            <th>Title</th><th>Author</th><th>Year</th><th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($book = $latestBooks->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author']) ?></td>
            <td><?= htmlspecialchars($book['year']) ?></td>
            <td><?= htmlspecialchars($book['type']) ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="actions">
    <button onclick="location.href='add.php'"><i class="fas fa-plus"></i> Add New Book</button>
    <button onclick="location.href='index.php'"><i class="fas fa-list"></i> View All Books</button>
    <button onclick="location.href='borrowed_books.php'"><i class="fa-solid fa-circle-user"></i> Borrowed Books</button>

</div>

<h3>📈 Books Added Per Year</h3>
<canvas id="booksLineChart" width="400" height="150"></canvas>

<script>
    const ctx = document.getElementById('booksLineChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2023', '2024', '2025'],
            datasets: [{
                label: 'Books Added',
                data: <?= json_encode(array_values($yearlyCounts)) ?>,
                borderColor: '#ffffff',
                backgroundColor: 'rgba(244, 241, 241, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointBackgroundColor: '#ffbd00',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<footer>
    <p>&copy; SHS within Sineguelasan Elementary School Library System 2025</p>
</footer>

</body>
</html>
