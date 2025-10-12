<?php
session_start();

// Hardcoded admin credentials
$admin_username = "jahandb";
$admin_password = "db123";

// Process login form submission
$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($username === $admin_username && $password === $admin_password) {
        // Authentication successful
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        // Redirect to index.php
        header("Location: journals.php");
        exit;
    } else {
        // Authentication failed
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Journal System</title>
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
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            height: 100vh;
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
            max-width: 400px;
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
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
            width: 100%;
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
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-container">
            <div class="login-header">
                <i class="bi bi-journal-check login-icon"></i>
                <h2>Journal Admin Portal</h2>
                <p class="mb-0">Sign in to your account</p>
            </div>
            
            <div class="login-body">
                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger error-alert alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $login_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="floating-label">
                        <input type="text" class="form-control floating-input" id="username" name="username" 
                               placeholder=" " value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <label for="username"><i class="bi bi-person"></i> Username</label>
                    </div>
                    
                    <div class="floating-label">
                        <input type="password" class="form-control floating-input" id="password" name="password" 
                               placeholder=" " required>
                        <label for="password"><i class="bi bi-lock"></i> Password</label>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login mb-3"><i class="bi bi-box-arrow-in-right"></i> Login</button>
                    
                    <div class="text-center">
                        <p class="mb-0">Default credentials: admin / 123</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
    </script>
</body>
</html>