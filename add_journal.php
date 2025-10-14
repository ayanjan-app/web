<?php
session_start();
include 'db.php'; // your database connection

// ----------------------
// Check if user is logged in
// ----------------------
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != 1) {
    die("You must be logged in to submit a journal.");
}

// Get logged-in user's ID
$user_id = $_SESSION['user_id']; // make sure you store user_id in session at login

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $author_first_name = htmlspecialchars(trim($_POST['author_first_name']));
    $author_last_name  = htmlspecialchars(trim($_POST['author_last_name']));
    $author_phone      = htmlspecialchars(trim($_POST['author_phone']));
    $author_email      = htmlspecialchars(trim($_POST['author_email']));
    $university_name   = htmlspecialchars(trim($_POST['university_name']));
    $department_name   = htmlspecialchars(trim($_POST['department_name']));
    $paper_title       = htmlspecialchars(trim($_POST['paper_title']));
    $province          = htmlspecialchars(trim($_POST['province']));

    // Handle PDF upload
    $pdf_file = "";
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $file_extension = strtolower(pathinfo($_FILES["pdf_file"]["name"], PATHINFO_EXTENSION));
        $file_name = uniqid() . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;

        if ($file_extension !== "pdf") {
            $error_message = "Only PDF files are allowed.";
        } elseif (!move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            $error_message = "Error uploading the PDF file.";
        } else {
            $pdf_file = $target_file;
        }
    } else {
        $error_message = "PDF file is required.";
    }

    // Insert into database if no errors
    if (empty($error_message)) {
        $stmt = $conn->prepare("
            INSERT INTO research_paper_submissions 
            (user_id, author_first_name, author_last_name, author_phone, author_email, university_name, department_name, paper_title, province, pdf_file, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $default_status = "noum"; // default status
        $stmt->bind_param(
            "issssssssss",
            $user_id,
            $author_first_name,
            $author_last_name,
            $author_phone,
            $author_email,
            $university_name,
            $department_name,
            $paper_title,
            $province,
            $pdf_file,
            $default_status
        );

        if ($stmt->execute()) {
            $success_message = "Journal submitted successfully!";
            $_POST = array(); // clear form
        } else {
            $error_message = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Journal Submission Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
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
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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
  </style>
</head>
<body>
  <div class="container">
    <div class="journal-container">
      <div class="text-center mb-5">
        <h1 class="page-header"><i class="bi bi-journal-text"></i> Academic Journal Submission</h1>
        <p class="text-muted">Submit your research paper for publication</p>
      </div>

      <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
      <?php endif; ?>
      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="form-section">
          <h5><i class="bi bi-person-circle"></i> Author Information</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">First Name</label>
              <input type="text" class="form-control" name="author_first_name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">Last Name</label>
              <input type="text" class="form-control" name="author_last_name" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">Phone</label>
              <input type="tel" class="form-control" name="author_phone" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">Email</label>
              <input type="email" class="form-control" name="author_email" required>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h5><i class="bi bi-building"></i> University Info</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">University Name</label>
              <input type="text" class="form-control" name="university_name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required-field">Department</label>
              <input type="text" class="form-control" name="department_name" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required-field">Province</label>
            <input type="text" class="form-control" name="province" required>
          </div>
        </div>

        <div class="form-section">
          <h5><i class="bi bi-file-earmark-pdf"></i> Paper Information</h5>
          <div class="mb-3">
            <label class="form-label required-field">Paper Title</label>
            <input type="text" class="form-control" name="paper_title" required>
          </div>
          <div class="mb-3">
            <label class="form-label required-field">Upload PDF</label>
            <input type="file" class="form-control" name="pdf_file" accept=".pdf" required>
          </div>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-submit"><i class="bi bi-send"></i> Submit Journal</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
