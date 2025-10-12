<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password
$dbname = "jahan_journal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$success_message = "";
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $author_first_name = htmlspecialchars(trim($_POST['author_first_name']));
    $author_last_name = htmlspecialchars(trim($_POST['author_last_name']));
    $author_phone = htmlspecialchars(trim($_POST['author_phone']));
    $author_email = htmlspecialchars(trim($_POST['author_email']));
    $university_name = htmlspecialchars(trim($_POST['university_name']));
    $department_name = htmlspecialchars(trim($_POST['department_name']));
    $paper_title = htmlspecialchars(trim($_POST['paper_title']));
    $province = htmlspecialchars(trim($_POST['province']));
    
    // Handle file upload
    $pdf_file = "";
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["pdf_file"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;
        
        // Check if file is a PDF
        if ($file_extension != "pdf") {
            $error_message = "Only PDF files are allowed.";
        } elseif (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            $pdf_file = $target_file;
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error_message = "PDF file is required.";
    }
    
    // Validate input and insert into database if no errors
    if (empty($error_message)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO research_paper_submissions (author_first_name, author_last_name, author_phone, author_email, university_name, department_name, paper_title, province, pdf_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $author_first_name, $author_last_name, $author_phone, $author_email, $university_name, $department_name, $paper_title, $province, $pdf_file);
        
        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Journal submitted successfully!";
            // Clear form fields
            $_POST = array();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Submission Form</title>
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
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #4e4e4e;
        }
        
        .journal-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-header {
            color: var(--primary-color);
            border-bottom: 3px solid var(--accent-color);
            padding-bottom: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .btn-submit {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .form-section {
            background-color: #f8f9fc;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--accent-color);
        }
        
        .form-section h5 {
            color: var(--secondary-color);
            margin-bottom: 1.2rem;
        }
        
        .required-field::after {
            content: " *";
            color: #e74a3b;
        }
        
        .upload-area {
            border: 2px dashed #d1d3e2;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            background-color: #f8f9fc;
        }
        
        .upload-area:hover {
            border-color: var(--primary-color);
            background-color: #eaecf4;
        }
        
        .upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
        }
        
        footer {
            background-color: white;
            padding: 1rem 0;
            margin-top: 2rem;
            border-top: 1px solid #e3e6f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="journal-container">
                    <div class="text-center mb-5">
                        <h1 class="page-header"><i class="bi bi-journal-text"></i> Academic Journal Submission</h1>
                        <p class="text-muted">Submit your research paper for publication</p>
                    </div>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill"></i> <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <!-- Author Information Section -->
                        <div class="form-section">
                            <h5><i class="bi bi-person-circle"></i> Author Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="author_first_name" class="form-label required-field">First Name</label>
                                    <input type="text" class="form-control" id="author_first_name" name="author_first_name" 
                                           value="<?php echo isset($_POST['author_first_name']) ? $_POST['author_first_name'] : ''; ?>" 
                                           placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="author_last_name" class="form-label required-field">Last Name</label>
                                    <input type="text" class="form-control" id="author_last_name" name="author_last_name" 
                                           value="<?php echo isset($_POST['author_last_name']) ? $_POST['author_last_name'] : ''; ?>" 
                                           placeholder="Enter your last name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="author_phone" class="form-label required-field">Phone Number</label>
                                    <input type="tel" class="form-control" id="author_phone" name="author_phone" 
                                           value="<?php echo isset($_POST['author_phone']) ? $_POST['author_phone'] : ''; ?>" 
                                           placeholder="Enter your phone number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="author_email" class="form-label required-field">Email Address</label>
                                    <input type="email" class="form-control" id="author_email" name="author_email" 
                                           value="<?php echo isset($_POST['author_email']) ? $_POST['author_email'] : ''; ?>" 
                                           placeholder="Enter your email address" required>
                                </div>
                            </div>
                        </div>

                        <!-- University Information Section -->
                        <div class="form-section">
                            <h5><i class="bi bi-building"></i> University Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="university_name" class="form-label required-field">University Name</label>
                                    <input type="text" class="form-control" id="university_name" name="university_name" 
                                           value="<?php echo isset($_POST['university_name']) ? $_POST['university_name'] : ''; ?>" 
                                           placeholder="Enter your university name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="department_name" class="form-label required-field">Department Name</label>
                                    <input type="text" class="form-control" id="department_name" name="department_name" 
                                           value="<?php echo isset($_POST['department_name']) ? $_POST['department_name'] : ''; ?>" 
                                           placeholder="Enter your department name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="province" class="form-label required-field">Province</label>
                                    <input type="text" class="form-control" id="province" name="province" 
                                           value="<?php echo isset($_POST['province']) ? $_POST['province'] : ''; ?>" 
                                           placeholder="Enter your province" required>
                                </div>
                            </div>
                        </div>

                        <!-- Paper Information Section -->
                        <div class="form-section">
                            <h5><i class="bi bi-file-text"></i> Paper Information</h5>
                            <div class="mb-3">
                                <label for="paper_title" class="form-label required-field">Paper Title</label>
                                <input type="text" class="form-control" id="paper_title" name="paper_title" 
                                       value="<?php echo isset($_POST['paper_title']) ? $_POST['paper_title'] : ''; ?>" 
                                       placeholder="Enter the title of your paper" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required-field">Upload PDF File</label>
                                <div class="upload-area">
                                  <i class="bi bi-cloud-upload upload-icon"></i>
                                  <p>Drag & drop your PDF file here or click to browse</p>
                                  <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                                  <div id="file-info" class="form-text">Only PDF files are accepted. Max file size: 10MB</div>
                              </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">Reset Form</button>
                            <button type="submit" class="btn btn-submit"><i class="bi bi-send"></i> Submit Journal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="text-muted">© <?php echo date('Y'); ?> Shahid Habibi & Rafiullah Ahmadzai - Journal Submission System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhance file upload UX
        const fileInput = document.getElementById('pdf_file');
        const uploadArea = document.querySelector('.upload-area');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                document.getElementById("file-info").innerHTML = `
                    <i class="bi bi-file-earmark-pdf-fill upload-icon"></i>
                    <p>Selected file: <strong>${fileName}</strong></p>
                `;
            }
        });

        
        function resetFileInput() {
            fileInput.value = ''; // Clear the file input

            uploadArea.innerHTML = `
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p>Drag & drop your PDF file here or click to browse</p>
                <div class="form-text">Only PDF files are accepted. Max file size: 10MB</div>
            `;
            uploadArea.appendChild(fileInput); // Put back the same file input
        }

        
        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#4e73df';
            this.style.backgroundColor = '#eaecf4';
        });
        
        uploadArea.addEventListener('dragleave', function() {
            this.style.borderColor = '#d1d3e2';
            this.style.backgroundColor = '#f8f9fc';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#d1d3e2';
            this.style.backgroundColor = '#f8f9fc';
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        });
    </script>
</body>
</html>