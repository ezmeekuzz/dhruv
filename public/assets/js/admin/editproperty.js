$(document).ready(function() {
    let fileCount = 0;
    let galleryContainer = $('#fileList');

    // Submit form handler
    $('#editproperty').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Validate required fields
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
                fieldElement.addClass('is-invalid');
            } else {
                fieldElement.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all the required fields!',
            });
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/admin/editproperty/update/' + formData.get('property_id'),
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred. Please try again later.',
                });
                console.error('Error:', xhr.responseText);
            }
        });
    });

    function loadPropertyGalleries(propertyId) {
        $.ajax({
            url: '/admin/editproperty/getGalleries/' + propertyId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                galleryContainer.empty();
                allFiles = []; // Reset the allFiles array

                if (data.length > 0) {
                    data.forEach(function(gallery, index) {
                        let galleryItem = `
                            <div class="file-wrapper" data-type="file-data" data-index="${index+1}" data-id="${gallery.property_gallery_id}" data-location="${gallery.location}">
                                <img src="/${gallery.location}" alt="" class="img-preview">
                                <span class="delete-btn-preview">&times;</span>
                                <span class="file-index">#${index+1}</span>
                                <!-- Hidden inputs to store the file data -->
                                <input type="hidden" name="files[]" data-index="${index+1}" value="${gallery.location}" class="form-control">
                                <input type="hidden" name="property_gallery_id[]" data-index="${index+1}" value="${gallery.property_gallery_id}" class="form-control">
                                <input type="hidden" name="order_sequence[]" data-index="${index+1}" value="${index+1}" class="form-control">
                            </div>`;
                        galleryContainer.append(galleryItem);
                        fileCount = index + 1; // Update fileCount to the latest index
                    });
                } else {
                    galleryContainer.append('<p>No galleries found for this property.</p>');
                }

                // Make the gallery sortable
                galleryContainer.sortable({
                    update: function(event, ui) {
                        updateGalleryIndices();
                    }
                });

                // Add event listener to delete buttons
                galleryContainer.on('click', '.delete-btn-preview', function() {
                    let fileWrapper = $(this).closest('.file-wrapper');
                    let propertyGalleryId = fileWrapper.data('id');
                    let fileLocation = fileWrapper.data('location');

                    // Send an AJAX request to delete the file from the server
                    $.ajax({
                        url: '/admin/editproperty/deleteGalleryFile',
                        type: 'POST',
                        data: {
                            property_gallery_id: propertyGalleryId,
                            file_location: fileLocation
                        },
                        success: function(response) {
                            if (response.success) {
                                fileWrapper.remove();
                                updateGalleryIndices(); // Update indices after removing an item
                            } else {
                                console.error('Error deleting file:', response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting file:', error);
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching galleries:', error);
            }
        });
    }

    function updateGalleryIndices() {
        let sortedGalleries = [];
        $('#fileList .file-wrapper').each(function(index) {
            $(this).attr('data-index', index + 1);
            $(this).find('.file-index').text('#' + (index + 1));
            $(this).find('input[name="order_sequence[]"]').val(index + 1);
            $(this).find('input[name="files[]"]').attr('data-index', index + 1);
            $(this).find('input[name="property_gallery_id[]"]').attr('data-index', index + 1);

            // Collect data to send to the server
            sortedGalleries.push({
                property_gallery_id: $(this).data('id'),
                order_sequence: index + 1
            });
        });

        // Optionally, send the updated order to the server if needed
        $.ajax({
            url: '/admin/editproperty/updateGalleryOrder',
            type: 'POST',
            data: { sortedGalleries: sortedGalleries },
            success: function(response) {
                console.log('Gallery order updated successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error updating gallery order:', error);
            }
        });
    }

    function handleFiles(files) {
        let formData = new FormData();
        let startIndex = fileCount + 1; // Start index from the last known file count
        formData.append('property_id', propertyId);

        console.log(propertyId);
    
        // Iterate over the files and append to FormData
        $.each(files, function(index, file) {
            formData.append('files[]', file);
            formData.append('order_sequence[]', startIndex);
            console.log(startIndex);
            startIndex++;
        });

        console.log(formData);
    
        // AJAX request to upload files and handle the response
        $.ajax({
            url: '/admin/editproperty/uploadGalleryFile', // Adjust the URL to your route
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    loadPropertyGalleries(propertyId);
                } else {
                    console.error('File upload failed:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error uploading file:', error);
            }
        });
    }    

    // Event listener for the file select button
    $('#fileSelectBtn').on('click', function() {
        createFileInput().click();
    });

    // Drag and Drop Functionality
    $('#uploadArea').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragging');
    });

    $('#uploadArea').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragging');
    });

    $('#uploadArea').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragging');
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    function createFileInput() {
        let fileInput = $('<input>')
            .attr('type', 'file')
            .attr('name', 'files[]')
            .attr('multiple', 'multiple')
            .attr('hidden', 'hidden')
            .on('change', function(e) {
                handleFiles(e.target.files);
            });

        $('#uploadArea').append(fileInput);
        return fileInput;
    }

    // Example usage:
    loadPropertyGalleries(propertyId);
});
