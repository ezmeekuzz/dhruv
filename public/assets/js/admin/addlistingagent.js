$(document).ready(function() {
    $('#addlistingagent').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var licenseno = $('#licenseno').val();
        var phonenumber = $('#phonenumber').val();
        var mobilenumber = $('#mobilenumber').val();
        var position = $('#position').val();
        var profileimage = $('#profileimage').prop('files')[0]; // Get selected file
        var url = $('#url').val();

        // Perform client-side validation
        if (fullname.trim() === '' || url.trim() === '' || email.trim() === '' || position.trim() === '' || licenseno.trim() === '' || phonenumber.trim() === '' || mobilenumber.trim() === '' || !profileimage) {
            // Show error using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all the required fields and select a profile image!',
            });
            return;
        }

        // Send AJAX request
        var formData = new FormData(this); // Create FormData object
        formData.append('profileimage', profileimage); // Append profile image to FormData

        $.ajax({
            type: 'POST',
            url: '/admin/addlistingagent/insert',
            data: formData,
            dataType: 'json',
            processData: false, // Prevent jQuery from processing data
            contentType: false, // Prevent jQuery from setting contentType
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
                    $('#addlistingagent')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
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
                    text: 'An error occurred. Please try again later.',
                });
                console.error(xhr.responseText);
            }
        });
    });
});
