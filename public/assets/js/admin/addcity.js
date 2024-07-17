$(document).ready(function() {
    $('#addcity').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        var state_id = $('#state_id').val();
        var cityname = $('#cityname').val();

        // Perform client-side validation
        if (state_id.trim() === '' && cityname.trim() === '') {
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
            url: '/admin/addcity/insert',
            data: $('#addcity').serialize(), // Serialize form data
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
                    $('#addcity')[0].reset();
                    $('#state_id').trigger('chosen:updated');
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