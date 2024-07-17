$(document).ready(function() {
    $('#edituser').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        let firstname = $('#firstname').val();
        let lastname = $('#lastname').val();
        let username = $('#username').val();
        let emailaddress = $('#emailaddress').val();
        let password = $('#password').val();
        let usertype = $('#usertype').val();

        // Perform client-side validation
        if (firstname.trim() === '' || lastname.trim() === '' || username.trim() === '' || emailaddress.trim() === '' || password.trim() === '' || usertype.trim() === '') {
            // Show error using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the required fields!',
            });
            return;
        }

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/edituser/update',
            data: $('#edituser').serialize(), // Serialize form data
            dataType: 'json',
            beforeSend: function() {
                // Show loading effect
                Swal.fire({
                    title: 'Updating...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success) {
                    // Redirect upon successful login
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Updated',
                        text: response.message,
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
                    text: 'An error occurred while logging in. Please try again later.',
                });
                console.error(xhr.responseText);
            }
        });
    });
});