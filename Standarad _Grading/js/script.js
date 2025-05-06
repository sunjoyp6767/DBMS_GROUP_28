document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.querySelector('.search-btn');
    const searchContainer = document.querySelector('.search-container');
    const table = document.getElementById('gradeTable');
    const rows = table.getElementsByTagName('tr');

    // Function to perform search
    function performSearch() {
        const searchText = searchInput.value.toLowerCase();
        
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(searchText) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    }

    // Search on input change
    searchInput.addEventListener('keyup', performSearch);

    // Search on button click
    searchBtn.addEventListener('click', function() {
        searchInput.focus();
        performSearch();
    });

    // Keep search bar expanded if it has content
    searchInput.addEventListener('input', function() {
        if (this.value) {
            searchContainer.style.width = '250px';
            searchInput.style.opacity = '1';
        }
    });

    // Collapse search on blur if empty
    searchInput.addEventListener('blur', function() {
        if (!this.value) {
            searchContainer.style.width = '40px';
            searchInput.style.opacity = '0';
        }
    });

    // Edit functionality
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gradeId = this.getAttribute('data-grade-id');
            const row = this.closest('tr');
            const cells = row.getElementsByTagName('td');

            // Populate the edit form
            document.getElementById('edit_grade_id').value = gradeId;
            document.getElementById('edit_description').value = cells[2].textContent;
            document.getElementById('edit_quality_score').value = parseFloat(cells[3].textContent);
            document.getElementById('edit_average_weight').value = parseFloat(cells[4].textContent);
            document.getElementById('edit_texture_quality').value = cells[5].textContent.trim();
            document.getElementById('edit_date_of_grading').value = cells[6].textContent;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editGradeModal'));
            editModal.show();
        });
    });

    // Add Form Submission with Confirmation
    const addForm = document.getElementById('addGradeForm');
    if (addForm) {
        addForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Save Grade Standard',
                text: 'Are you sure you want to save this new grade standard?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Saving...',
                        html: '<div class="progress" style="height: 20px;">' +
                              '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" ' +
                              'role="progressbar" style="width: 100%"></div>' +
                              '</div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    
                    // Submit the form
                    const formData = new FormData(addForm);
                    fetch('includes/add_grade.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Show success message
                        Swal.fire({
                            title: 'Saved!',
                            text: 'The grade standard has been added successfully.',
                            icon: 'success',
                            confirmButtonColor: '#20c997'
                        }).then(() => {
                            // Refresh page or update the table
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error saving the grade: ' + error.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                }
            });
        });
    }

    // Edit Form Submission with Confirmation
    const editForm = document.getElementById('editGradeForm');
    if (editForm) {
        editForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Update Grade Standard',
                text: 'Are you sure you want to update this grade standard?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0dcaf0',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Updating...',
                        html: '<div class="progress" style="height: 20px;">' +
                              '<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" ' +
                              'role="progressbar" style="width: 100%"></div>' +
                              '</div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    
                    // Submit the form
                    const formData = new FormData(editForm);
                    fetch('includes/update_grade.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Show success message
                        Swal.fire({
                            title: 'Updated!',
                            text: 'The grade standard has been updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#0dcaf0'
                        }).then(() => {
                            // Refresh page or update the table
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error updating the grade: ' + error.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                }
            });
        });
    }

    // Delete functionality with confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gradeId = this.getAttribute('data-grade-id');
            const row = this.closest('tr');
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Delete Grade Standard',
                text: 'Are you sure you want to delete this grade standard? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        html: '<div class="progress" style="height: 20px;">' +
                              '<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" ' +
                              'role="progressbar" style="width: 100%"></div>' +
                              '</div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    
                    // Send delete request
                    fetch('includes/delete_grade.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'grade_id=' + gradeId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The grade standard has been deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Remove row from table
                                row.remove();
                            });
                        } else {
                            throw new Error(data.error);
                        }
                    })
                    .catch(error => {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error deleting the grade: ' + (error.message || 'Unknown error'),
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                }
            });
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Remove URL parameters if present
    if (window.location.search) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});