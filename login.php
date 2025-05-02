<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Sineg Library System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login-body">

    <!-- Background video -->
    <video autoplay muted loop id="bg-video">
        <source src="image/background video.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Login Form -->
    <div class="login-container">
    <div class="logo-container">
        <img src="image/logo.png" alt="Logo" class="logo">
    </div>
    <h1>Sineg Library System</h1>
    <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">Invalid username or password.</div>
    <?php endif; ?>
    <form action="authenticate.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</div>


</body>

<style> 
/* Scope styles only to  form */
/* Ensure full screen and no scroll */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

/* Background video full screen and behind */
#bg-video {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1; /* Send behind everything */
}

/* Flex layout to center the login box */
.login-body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

/* Login form box styling */
.login-container {
    z-index: 1; /* On top of video */
    background-color: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    width: 300px;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.login-container input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.login-container button {
    width: 100%;
    padding: 10px;
    background-color: #ffbf00;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.login-container button:hover {
    background-color: #e0a800;
}
.login-container .error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
}
.login-container .success-message {
    color: green;
    margin-top: 10px;
    font-size: 14px;
}
.logo {
    width: 80px;  /* Adjust size as needed */
    height: auto;
    margin-bottom: 20px; /* Space between logo and form */
    align-self: center; /* Center the logo */
    display: block; /* Center the logo */
    margin-left: auto; /* Center the logo */
    margin-right: auto; /* Center the logo */
}

h1 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
    margin-left: 40px;
    margin-top: 0px;
}

h2 {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
    margin-left: 5px;
    margin-top: 0px;
}
h3 {
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
    margin-left: 40px;
    margin-top: 0px;
}
</style>
</html>
