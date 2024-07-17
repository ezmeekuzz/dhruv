$(document).ready(function() {
    $('#editproperty').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Create FormData object
        var formData = new FormData(this);

        // Perform client-side validation
        var requiredFields = [
            'propertyname', 'real_estate_type', 'property_type_id', 'listing_agent_id',
            'price', 'price_per_sf', 'caprate', 'state_id', 'city_id', 'zipcode', 'tenancy',
            'buildingsize', 'yearbuilt', 'location'
        ];
        var isValid = true;

        requiredFields.forEach(function(field) {
            var fieldElement = $('[name="' + field + '"]');
            if (!formData.get(field)) {
                isValid = false;
                fieldElement.addClass('is-invalid'); // Add 'is-invalid' class to highlight the field
            } else {
                fieldElement.removeClass('is-invalid'); // Remove 'is-invalid' class if the field is valid
            }
        });

        if (!isValid) {
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
            url: '/admin/editproperty/update/' + formData.get('property_id'),
            data: formData, // Use FormData object
            dataType: 'json',
            processData: false, // Do not process data
            contentType: false, // Do not set contentType
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
                    $('#editproperty')[0].reset();
                    $('.chosen-select').trigger('chosen:updated');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });

                    // Remove dynamically added investment highlights and retain default
                    $('.investmenthighlights').empty();

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

    $('#state_id').on('change', function() {
        let stateId = $(this).val();

        if (stateId) {
            $.ajax({
                url: `/admin/editproperty/getCities/${stateId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let citySelect = $('#city_id');
                    citySelect.empty(); // Clear previous options
                    citySelect.append('<option hidden></option><option disabled></option>');

                    if (data && data.length > 0) {
                        $.each(data, function(index, city) {
                            citySelect.append(`<option value="${city.city_id}">${city.cityname}</option>`);
                        });
                    }

                    // If you are using Chosen jQuery plugin, you need to trigger an update
                    citySelect.trigger("chosen:updated");
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });

    $(document).on('change', '.custom-file-input', function() {
        var file = this.files[0].name;
        $(this).siblings('.custom-file-label').text(file.substring(0, 20));
    });

    function filter() {
        let search = $('#searchlistingagent').val().toUpperCase();
        $('#agentlist li').each(function() {
            let label = $(this).find('label').text().toUpperCase();
            if (label.includes(search)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Manually trigger filtering function on keyup event
    $('#searchlistingagent').on('keyup', filter);

    // Initial filtering
    filter();
});

function addinvestmenthighlight() {
    var elem = "";
    elem += '<div class="InvestmentHighlightLists"><div class="form-group"><label for="content" style="float: left;">Investment Highlight</label><div style="float: right;"><a href="javascript:void(0);" onclick="addinvestmenthighlight();" title="Add Investment Highlight"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a><a href="javascript:void(0);" style="color: red; font-size: 18px;" class="remove-investment-highlight"><i class="fa fa-trash"></i></a></div><input type="text" name="title[]" id="title" class="form-control mb-3" placeholder="Enter Title"><textarea class="form-control" id="content" name="content[]" placeholder="Content" style="resize: none; min-height: 80px;"></textarea></div></div>';
    $('.investmenthighlights').append(elem);
}
$('.investmenthighlights').on('click', '.remove-investment-highlight', function() {
    $(this).closest('.InvestmentHighlightLists').remove();
});
