<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Product Grading Standards</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Existing styles */
        .table-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }
        .badge-beef { background-color: #ff6b6b; color: white; }
        .badge-pork { background-color: #4ecdc4; color: white; }
        .badge-chicken { background-color: #ffe66d; color: black; }
        .badge-tender { background-color: #95e1d3; color: white; }
        .badge-medium { background-color: #fce38a; color: black; }
        .badge-firm { background-color: #eaffd0; color: black; }
        .quality-score { font-weight: bold; }
        .quality-high { color: #28a745; }
        .quality-medium { color: #ffc107; }
        .quality-low { color: #dc3545; }
        .action-buttons { display: flex; gap: 5px; }
        .action-buttons button { padding: 5px 10px; }
        .action-buttons i { margin-right: 5px; }

        /* New sidebar styles */
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 60px;
        }
        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0px;
            z-index: 1030;
        }
        .top-bar {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: end;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../Standarad _Grading/grading_standard.php">Grading Standards</a>
        <a href="../dashboard.html" onclick="return showSection('reports')">Reports</a>
        <a href="../trackmeat.html">Meat Tracking</a>
        <a href="../dashboard.html" onclick="return showSection('quality')">Quality Analysis</a>
        <a href="../dashboard.html" onclick="return showSection('packaging')">Packaging Oversight</a>
        <a href="../dashboard.html" onclick="return showSection('transport')">Transport Monitoring</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">TrackNGrade</a>
                <div class="dropdown ms-auto">
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" id="usernameDisplay">User</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <!-- Search and Add Button Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-container">
                                <input type="text" id="searchInput" class="search-input" placeholder="Search...">
                                <button class="search-btn" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-add-standard" data-bs-toggle="modal" data-bs-target="#addGradeModal">
                                <i class="fas fa-plus"></i> Add New Standard
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="gradeTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Grade ID</th>
                                    <th>Product Type</th>
                                    <th>Description</th>
                                    <th>Quality Score</th>
                                    <th>Average Weight</th>
                                    <th>Texture Quality</th>
                                    <th>Date of Grading</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'includes/fetch_grades.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Grade Modal -->
        <div class="modal fade" id="addGradeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white rounded-top">
                        <h5 class="modal-title">Add New Grading Standard</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body simple-modal-body">
                        <form id="addGradeForm" action="includes/add_grade.php" method="POST">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="product_type_id" id="add_product_type_id" required>
                                    <?php include 'includes/fetch_product_types.php'; ?>
                                </select>
                                <label for="add_product_type_id">Product Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="quality_score" id="add_quality_score" step="0.01" required>
                                <label for="add_quality_score">Quality Score</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="description" id="add_description" style="height: 80px" required></textarea>
                                <label for="add_description">Description</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="average_weight" id="add_average_weight" step="0.01" required>
                                <label for="add_average_weight">Average Weight (kg)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="texture_quality" id="add_texture_quality" required>
                                    <option value="Tender">Tender</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Firm">Firm</option>
                                </select>
                                <label for="add_texture_quality">Texture Quality</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="date" class="form-control" name="date_of_grading" id="add_date_of_grading" required>
                                <label for="add_date_of_grading">Date of Grading</label>
                            </div>
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn modal-save-btn flex-fill">
                                    <i class="fas fa-check"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Grade Modal -->
        <div class="modal fade" id="editGradeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white rounded-top">
                        <h5 class="modal-title">Edit Grading Standard</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body simple-modal-body">
                        <form id="editGradeForm" action="includes/update_grade.php" method="POST">
                            <input type="hidden" name="grade_id" id="edit_grade_id">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="product_type_id" id="edit_product_type_id" required>
                                    <?php include 'includes/fetch_product_types.php'; ?>
                                </select>
                                <label for="edit_product_type_id">Product Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="quality_score" id="edit_quality_score" step="0.01" required>
                                <label for="edit_quality_score">Quality Score</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="description" id="edit_description" style="height: 80px" required></textarea>
                                <label for="edit_description">Description</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="average_weight" id="edit_average_weight" step="0.01" required>
                                <label for="edit_average_weight">Average Weight (kg)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="texture_quality" id="edit_texture_quality" required>
                                    <option value="Tender">Tender</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Firm">Firm</option>
                                </select>
                                <label for="edit_texture_quality">Texture Quality</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="date" class="form-control" name="date_of_grading" id="edit_date_of_grading" required>
                                <label for="edit_date_of_grading">Date of Grading</label>
                            </div>
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn modal-update-btn flex-fill">
                                    <i class="fas fa-sync-alt"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
    <script>
        // Add sidebar functionality
        function showSection(sectionId) {
            // Store the section to show in localStorage
            localStorage.setItem('activeSection', sectionId);
            // Navigate to dashboard
            window.location.href = '../dashboard.html';
            return false; // Prevent default link behavior
        }

        // Check for active section on page load
        document.addEventListener('DOMContentLoaded', function() {
            const activeSection = localStorage.getItem('activeSection');
            if (activeSection) {
                // Clear the stored section
                localStorage.removeItem('activeSection');
                // Show the section
                const section = document.getElementById(activeSection);
                if (section) {
                    section.classList.add('active');
                }
            }
        });

        function logout() {
            // Handle logout
            console.log('Logging out...');
            window.location.href = '../index.html';
        }
    </script>
</body>
</html> 