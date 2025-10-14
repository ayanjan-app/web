<?php
session_start();
include 'db.php';

// Hardcoded admin credentials
$admin_username = "rafi";
$admin_password = "db12345";

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    if ($user_type === "admin") {
        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = 'admin';
            $_SESSION['user_id'] = 0; // optional for admin
            header("Location: journals.php");
            exit;
        } else {
            $login_error = "Invalid admin credentials";
        }
    } else {
        // User authentication
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = 'user';
                $_SESSION['user_id'] = $row['id'];
                header("Location: add_journal.php");
                exit;
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "User not found.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Professional Platform</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6f42c1;
            --accent-color: #36b9cc;
            --light-bg: #f8f9fc;
            --user-color: #4e73df;
            --admin-color: #e74a3b;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        
        .login-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-login {
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-user {
            background: linear-gradient(to right, var(--user-color), #6f8de0);
        }
        
        .btn-admin {
            background: linear-gradient(to right, var(--admin-color), #e96c5f);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }
        
        .login-icon {
            font-size: 5rem;
            color: white;
            margin-bottom: 1rem;
        }
        
        .error-alert {
            border-radius: 10px;
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% {transform: translateX(0);}
            10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
            20%, 40%, 60%, 80% {transform: translateX(5px);}
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .floating-input {
            height: 50px;
            padding: 1rem 0.75rem;
        }
        
        .floating-label label {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            pointer-events: none;
            transition: all 0.3s;
            color: #6c757d;
        }
        
        .floating-input:focus ~ label,
        .floating-input:not(:placeholder-shown) ~ label {
            top: 0;
            left: 10px;
            background-color: white;
            padding: 0 5px;
            font-size: 0.8rem;
            color: var(--primary-color);
        }
        
        .user-type-selector {
            display: flex;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .user-type-option {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.3s;
            background-color: var(--light-bg);
        }
        
        .user-type-option.active {
            background-color: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        
        .user-type-option.user.active {
            border-bottom: 3px solid var(--user-color);
        }
        
        .user-type-option.admin.active {
            border-bottom: 3px solid var(--admin-color);
        }
        
        .user-type-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .user-type-option.user.active i {
            color: var(--user-color);
        }
        
        .user-type-option.admin.active i {
            color: var(--admin-color);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-container">
            <div class="login-header">
                <i class="bi bi-shield-check login-icon"></i>
                <h2>Secure Login Portal</h2>
                <p class="mb-0">Select your account type and sign in</p>
            </div>
            
            <div class="login-body">
                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger error-alert alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $login_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="user-type-selector">
                    <div class="user-type-option user active" data-type="user">
                        <i class="bi bi-person"></i>
                        <div>User Login</div>
                    </div>
                    <div class="user-type-option admin" data-type="admin">
                        <i class="bi bi-shield-lock"></i>
                        <div>Admin Login</div>
                    </div>
                </div>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" id="user_type" name="user_type" value="user">
                    
                    <div class="floating-label">
                        <input type="text" class="form-control floating-input" id="username" name="username" 
                               placeholder=" " value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <label for="username"><i class="bi bi-person"></i> Username</label>
                    </div>
                    
                    <div class="floating-label">
                        <input type="password" class="form-control floating-input" id="password" name="password" 
                               placeholder=" " required>
                        <label for="password"><i class="bi bi-lock"></i> Password</label>
                        <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                            <i class="bi bi-eye" id="togglePassword"></i>
                        </span>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login btn-user mb-3" id="loginButton">
                        <i class="bi bi-box-arrow-in-right"></i> Login as User
                    </button>
                    
                    <div class="login-footer">
                        <p>Don't have an account? <a href="register.php">Sign up here</a></p>
                        <div id="adminCredentials" class="d-none">
                            <p class="small text-muted">Default admin credentials: jahandb / db123</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // User type selection
        document.querySelectorAll('.user-type-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                document.querySelectorAll('.user-type-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                
                // Add active class to clicked option
                this.classList.add('active');
                
                // Update hidden input
                const userType = this.getAttribute('data-type');
                document.getElementById('user_type').value = userType;
                
                // Update login button
                const loginButton = document.getElementById('loginButton');
                const adminCredentials = document.getElementById('adminCredentials');
                
                if (userType === 'admin') {
                    loginButton.textContent = 'Login as Admin';
                    loginButton.className = 'btn btn-login btn-admin mb-3';
                    adminCredentials.classList.remove('d-none');
                } else {
                    loginButton.textContent = 'Login as User';
                    loginButton.className = 'btn btn-login btn-user mb-3';
                    adminCredentials.classList.add('d-none');
                }
            });
        });
        
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
        
        // Add floating label functionality
        document.querySelectorAll('.floating-input').forEach(input => {
            // Check if input has value on page load (for browser autofill)
            if (input.value) {
                input.parentElement.querySelector('label').classList.add('active');
            }
            
            input.addEventListener('focus', () => {
                input.parentElement.querySelector('label').classList.add('active');
            });
            
            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.parentElement.querySelector('label').classList.remove('active');
                }
            });
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (username.length < 3) {
                alert('Username must be at least 3 characters long');
                e.preventDefault();
                return;
            }
            
            if (password.length < 6) {
                alert('Password must be at least 6 characters long');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>