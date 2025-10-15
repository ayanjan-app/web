<?php
session_start(); // MUST be the very first line

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != 1) {
    die("You must be logged in to submit or view papers.");
}

// Get logged-in user's ID
$user_id = $_SESSION['user_id'];

$success_message = "";
$error_message = "";

// ---------- Handle form submission ----------
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
        $default_status = "pending"; // default status
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

// ---------- Fetch user's submitted journals ----------
$user_journals_sql = "SELECT * FROM research_paper_submissions WHERE user_id = ? ORDER BY submission_date DESC";
$stmt = $conn->prepare($user_journals_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_journals = $stmt->get_result();
?>

<!-- HTML starts here -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Journal Submission Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
  <style>
    /* Your existing styles remain exactly the same */
    .journal-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    .page-header {
      color: #4e73df;
      border-bottom: 2px solid #36b9cc;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .btn-view-comment {
      background-color: #36b9cc;
      color: white;
      border: none;
    }
    .btn-view-comment:hover {
      background-color: #2c9faf;
      color: white;
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

        <!-- Your existing form code remains exactly the same -->
        <form method="POST" enctype="multipart/form-data">
            <!-- Your complete form sections here -->
            <!-- Author Information -->
            <div class="card card-custom shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-person"></i> Author Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author_first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="author_first_name" name="author_first_name" 
                                       value="<?= $_POST['author_first_name'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author_last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="author_last_name" name="author_last_name" 
                                       value="<?= $_POST['author_last_name'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author_phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="author_phone" name="author_phone" 
                                       value="<?= $_POST['author_phone'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="author_email" name="author_email" 
                                       value="<?= $_POST['author_email'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- University Information -->
            <div class="card card-custom shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-building"></i> University Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="university_name" class="form-label">University Name *</label>
                                <input type="text" class="form-control" id="university_name" name="university_name" 
                                       value="<?= $_POST['university_name'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department_name" class="form-label">Department Name *</label>
                                <input type="text" class="form-control" id="department_name" name="department_name" 
                                       value="<?= $_POST['department_name'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paper Information -->
            <div class="card card-custom shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-file-text"></i> Paper Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="paper_title" class="form-label">Paper Title *</label>
                                <input type="text" class="form-control" id="paper_title" name="paper_title" 
                                       value="<?= $_POST['paper_title'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="province" class="form-label">Province *</label>
                                <select class="form-select" id="province" name="province" required>
                                    <option value="">Select Province</option>
                                    <option value="Kabul" <?= (($_POST['province'] ?? '') == 'Kabul') ? 'selected' : '' ?>>Kabul</option>
                                    <option value="Herat" <?= (($_POST['province'] ?? '') == 'Herat') ? 'selected' : '' ?>>Herat</option>
                                    <option value="Balkh" <?= (($_POST['province'] ?? '') == 'Balkh') ? 'selected' : '' ?>>Balkh</option>
                                    <option value="Kandahar" <?= (($_POST['province'] ?? '') == 'Kandahar') ? 'selected' : '' ?>>Kandahar</option>
                                    <option value="Nangarhar" <?= (($_POST['province'] ?? '') == 'Nangarhar') ? 'selected' : '' ?>>Nangarhar</option>
                                    <!-- Add more provinces as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Upload PDF *</label>
                        <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                        <div class="form-text">Only PDF files are allowed. Maximum size: 10MB</div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send"></i> Submit Journal</button>
            </div>
        </form>

        <!-- Display User's Submitted Papers - Only added Comment column -->
        <div class="mt-5">
          <h3 class="page-header"><i class="bi bi-journal-text"></i> Your Submitted Papers</h3>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Paper Title</th>
                  <th>University</th>
                  <th>Department</th>
                  <th>Submission Date</th>
                  <th>Status</th>
                  <th>PDF</th>
                  <th>Comment</th> <!-- Added this column -->
                </tr>
              </thead>
              <tbody>
                <?php
                if ($user_journals->num_rows > 0) {
                    while ($row = $user_journals->fetch_assoc()) {
                        $status = $row['status'];
                        if ($status === 'approved') $badge = "<span class='badge bg-success'>Approved</span>";
                        elseif ($status === 'rejected') $badge = "<span class='badge bg-danger'>Rejected</span>";
                        else $badge = "<span class='badge bg-secondary'>Pending</span>";

                        // ADDED: Comment button logic
                        $has_comment = !empty($row['comment']);
                        $comment_button = $has_comment 
                            ? "<button class='btn btn-sm btn-view-comment' data-bs-toggle='modal' data-bs-target='#commentModal' data-paper-id='{$row['id']}' data-comment='".htmlspecialchars($row['comment'])."'><i class='bi bi-chat-left-text'></i> View Comment</button>"
                            : "<span class='text-muted'><i class='bi bi-chat-left'></i> No Comment</span>";

                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['paper_title']}</td>
                            <td>{$row['university_name']}</td>
                            <td>{$row['department_name']}</td>
                            <td>" . date('M j, Y', strtotime($row['submission_date'])) . "</td>
                            <td>$badge</td>
                            <td><a href='{$row['pdf_file']}' target='_blank' class='btn btn-sm btn-primary'><i class='bi bi-file-earmark-pdf'></i> View PDF</a></td>
                            <td>$comment_button</td> <!-- Added this cell -->
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>You have not submitted any papers yet.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

<!-- ADDED: Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-chat-left-text"></i> Admin Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Paper Title:</strong> <span id="modal_paper_title"></span>
                </div>
                <div class="mb-3">
                    <strong>Admin Feedback:</strong>
                    <div class="alert alert-info mt-2" id="modal_comment_text" style="white-space: pre-line;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ADDED: Handle comment modal
    $('#commentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var paperId = button.data('paper-id');
        var comment = button.data('comment');
        var modal = $(this);
        
        // Find the paper title from the table row
        var paperTitle = button.closest('tr').find('td:nth-child(2)').text();
        
        // Set modal content
        modal.find('#modal_paper_title').text(paperTitle);
        modal.find('#modal_comment_text').text(comment);
    });
</script>
</body>
</html>

<?php
// Close database connection
$stmt->close();
$conn->close();
?>