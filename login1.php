<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM users WHERE username='$username'");

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $username;
      echo "Login successful! <a href='home.php'>Go to home</a>";
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "User not found.";
  }
}
?>

<form method="POST">
  <h2>Login</h2>
  Username: <input type="text" name="username" required><br><br>
  Password: <input type="password" name="password" required><br><br>
  <button type="submit">Login</button>
</form>
