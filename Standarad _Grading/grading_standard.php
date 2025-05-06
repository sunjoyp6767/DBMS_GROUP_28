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
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white py-4">
        <div class="container">
            <h1 class="text-center mb-0">Meat Product Grading Standards</h1>
        </div>
    </header>

    <div class="container mt-4">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html> 