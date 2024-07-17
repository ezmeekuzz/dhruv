$(document).ready(function() {
    $('#editlistingagent').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        var formData = new FormData(this);
        
        // Perform client-side validation
        var fullname = $('#fullname').val().trim();
        var email = $('#email').val().trim();
        var licenseno = $('#licenseno').val().trim();
        var phonenumber = $('#phonenumber').val().trim();
        var mobilenumber = $('#mobilenumber').val().trim();
        var position = $('#position').val().trim();

        if (fullname === '' || email === '' || licenseno === '' || phonenumber === '' || mobilenumber === '' || position === '') {
            // Show error using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all the required fields!',
            });
            return;
        }

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/editlistingagent/update',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                // Show loading effect
                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success) {
                    // Reset form and show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then(function() {
                        location.reload(); // Reload page or perform other actions
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred. Please try again later.',
                });
                console.error(xhr.responseText);
            }
        });
    });
});
