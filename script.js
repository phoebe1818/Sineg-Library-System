const ctx = document.getElementById('reportChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['New Book', 'Book Issued', 'New Member', 'Not Returned'],
        datasets: [{
            label: 'Reports (Last 7 days)',
            data: [10, 14, 9, 4],
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});


function toggleDropdown() {
    const menu = document.getElementById('adminMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Optional: Hide dropdown if user clicks outside
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.admin-dropdown');
    if (!dropdown.contains(event.target)) {
        document.getElementById('adminMenu').style.display = 'none';
    }
});

