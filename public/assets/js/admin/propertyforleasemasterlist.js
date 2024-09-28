$(document).ready(function () {
    
    const dropZone = $('#drop-zone');
    const dropZone2 = $('#edit_drop-zone');
    const inputFile = $('#site_plan_map');
    const inputFile2 = $('#edit_site_plan_map');
    const previewContainer = $('#preview-container');
    const previewContainer2 = $('#edit_preview-container');
    let files = [];
    
    var table = $('#propertyforleasemasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/propertyforleasemasterlist/getData",
            "type": "GET"
        },
        "columns": [
            { "data": "property_name" },
            { "data": "anchor_tenant" },
            { "data": "spacetype" },
            { "data": "fullname" },
            { "data": "rental_rate" },
            { "data": "publishstatus" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<a href="/admin/edit-property-for-lease/${row.property_id}" title="Edit" class="edit-btn" data-id="${row.property_id}" style="color: blue;"><i class="fa fa-edit" style="font-size: 18px;"></i></a>
                            <a href="#" title="Sold" class="sold-btn" data-id="${row.property_id}" style="color: green;"><i class="fa fa-money" style="font-size: 18px;"></i></a>
                            <a href="#" title="Add Leasing Units" class="add-leasing-units" data-id="${row.property_id}" style="color: orange;"><i class="fa fa-plus-circle" style="font-size: 18px;"></i></a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.property_id}" style="color: red;"><i class="fa fa-trash" style="font-size: 18px;"></i></a>`;
                }
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            if (data.soldstatus === 'sold') {
                $(row).addClass('sold-property');  // Add a custom class for sold properties
            }
            $(row).attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').addClass('propertyForLeaseDetails');
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });
    
    // Add custom CSS to style the sold property rows
    $('<style>')
        .prop('type', 'text/css')
        .html('.sold-property { background-color: #d3d3d3; }') // Grayish color for sold properties
        .appendTo('head');
    
    // SweetAlert2 confirmation for Sold button
    $(document).on('click', '.sold-btn', function (e) {
        e.preventDefault(); // Prevent the default action of the button
    
        var propertyId = $(this).data('id'); // Get the property ID from the button
    
        // Show SweetAlert2 confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to mark this property as sold!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, mark as sold!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to mark the property as sold
                $.ajax({
                    url: '/admin/propertyforleasemasterlist/markAsSold',  // Your backend URL to handle the sold action
                    type: 'POST',
                    data: { property_id: propertyId },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Sold!',
                                'The property has been marked as sold.',
                                'success'
                            );
                            // Optionally, you can reload the DataTable to reflect the changes
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX errors
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });   

    $(document).on('click', '.add-leasing-units', function (e) {
        e.preventDefault();
        
        // Get the property_id from the clicked button
        var property_id = $(this).data('id');
        
        // Populate the property_id field in the modal
        $('#property_id').val(property_id);
        
        // Show the modal
        $('#addLeasingUnitsModal').modal('show');
    });

    $('#saveLeasingUnits').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior
    
        // Collect form data
        var property_id = $('#property_id').val();
        var unit_number = $('#unit_number').val();
        var cam = $('#cam').val();
        var leasing_rental_rate = $('#leasing_rental_rate').val();
        var space_available = $('#space_available').val();
        var space_use = $('#space_use').val();
    
        // Check if any field is empty (simple validation)
        if (!property_id || !unit_number || !cam || !leasing_rental_rate || !space_available || !space_use) {
            // Show SweetAlert2 error message
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields before submitting.',
            });
            return; // Stop the form submission
        }
    
        // Create FormData object and collect all form data
        var formData = new FormData($('#addLeasingUnitsForm')[0]); // Collect the form data, including file
    
        // Append all files from the 'files' array in the handleFiles function
        files.forEach((file) => {
            formData.append('site_plan_map[]', file); // Adjust for multiple files
        });
    
        $.ajax({
            url: '/admin/propertyforleasemasterlist/addLeasingUnit', // Adjust the URL based on your backend route
            type: 'POST',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function (response) {
                if (response.success) {
                    // Close the modal on success and show a success message with SweetAlert2
                    $('#addLeasingUnitsModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message, // Use the message returned by the server
                    });
                } else {
                    // Show SweetAlert2 error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message, // Use the message returned by the server
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle AJAX errors here (e.g., network/server issues)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            }
        });
    });       

    $(document).on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/propertyforleasemasterlist/delete/' + id,
                    method: 'DELETE',
                    success: function (response) {
                        if (response.status === 'success') {
                            table.row(row).remove().draw(false);
                        } else {
                            // Handle unsuccessful deletion
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    },
                    error: function () {
                        // Handle AJAX request error
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong with the request!',
                        });
                    }
                });
            }
        });
    });
    $(document).on('click', '.propertyForLeaseDetails', function () {
        let propertyId = $(this).data("id");
    
        $.ajax({
            type: "GET",
            url: "/admin/propertyforleasemasterlist/propertyDetails",
            data: { propertyId: propertyId },
            success: function (response) {
                // Access specific properties from the response object
                let fullname = response.fullname;
                let images = response.property_galleries; 
                let property_name = response.property_name;
                let location = response.location;
                let anchor_tenant = response.anchor_tenant;
                let rental_rate = response.rental_rate;
                let state_name = response.state_name;
                let cityname = response.cityname;
                let zipcode = response.zipcode;
                let leasestructure = response.leasestructure;
                let addt = response.addt;
                let buildingsize = response.buildingsize;
                let yearbuilt = response.yearbuilt;
                let size_sf = response.size_sf;
                let starting_sf_yr = response.starting_sf_yr;
                let ending_sf_yr = response.ending_sf_yr;
    
                // Generate carousel indicators and items dynamically
                let indicators = '';
                let carouselItems = '';
                images.forEach((imageUrl, index) => {
                    indicators += `<li data-target="#carouselExampleIndicators" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>`;
                    carouselItems += `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <img class="d-block w-100" src="/${imageUrl.location}" alt="Slide ${index + 1}">
                            <button class="btn btn-danger btn-sm position-absolute delete-image-btn" style="top: 10px; right: 10px;" data-id="${imageUrl.property_gallery_id}"><i class="fa fa-trash"></i></button>
                        </div>
                    `;
                });
    
                // Format the content as HTML using template literals
                let htmlContent = `
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            ${indicators}
                        </ol>
                        <div class="carousel-inner">
                            ${carouselItems}
                            <div class="carousel-item">
                                <img class="d-block w-100" src="/${response.backgroundimage}" alt="Slide firstSlide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="property-details mt-3">
                        <div>
                            <p><span class="font-weight-bold">Listing Agent</span>: ${fullname}</p>
                        </div>
                        <div class="content mt-3">
                            <ul class="list-group">
                                <li class="list-group-item"><span class="font-weight-bold">Anchor Tenant</span>: ${anchor_tenant}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Rental Rate</span>: ${rental_rate}</li>
                                <li class="list-group-item"><span class="font-weight-bold">States</span>: ${state_name}</li>
                                <li class="list-group-item"><span class="font-weight-bold">City</span>: ${cityname}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Zip Code</span>: ${zipcode}</li>
                                <li class="list-group-item"><span class="font-weight-bold">ADDT</span>: ${addt}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Building Size</span>: ${buildingsize}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Year Built</span>: ${yearbuilt}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Lease Structure</span>: ${leasestructure}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Size SF</span>: ${size_sf}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Starting SF Yr</span>: ${starting_sf_yr}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Ending SF Yr</span>: ${ending_sf_yr}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Leasing Flyer</span>: <a href="/${response.leasing_flyer}" target="_blank" class="btn btn-primary"><i class="fa fa-share"></i> Open</a></li>
                            </ul>
                        </div>
                    </div>
                `;
    
                // Leasing Units Section
                htmlContent += `
                    <div class="leasing-units mt-3">
                        <h4>Leasing Units</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Unit Number</th>
                                    <th>CAM</th>
                                    <th>Rental Rate</th>
                                    <th>Space Available</th>
                                    <th>Space Use</th>
                                    <th>Site Plan Map</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="leasing-units-sortable">
                `;
    
                if (response.leasing_units.length > 0) {
                    response.leasing_units.forEach(unit => {
                        htmlContent += `
                            <tr data-id="${unit.leasing_unit_id}">
                                <td>${unit.unit_number}</td>
                                <td>${unit.cam}</td>
                                <td>${unit.leasing_rental_rate} sq.ft.</td>
                                <td>${unit.space_available}</td>
                                <td>${unit.space_use}</td>
                                <td><img src="/${unit.location}" style="width: 100%;" /></td>
                                <td>
                                    <a href="javascript:void(0);" class="edit-unit-btn" data-id="${unit.leasing_unit_id}"><i class="fa fa-edit" style="color: blue; font-size: 18px;"></i></a>
                                    <a href="javascript:void(0);" class="delete-unit-btn" data-id="${unit.leasing_unit_id}"><i class="fa fa-trash" style="color: red; font-size: 18px;"></i></a>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    htmlContent += `<tr><td colspan="6" class="text-center">No leasing units available</td></tr>`;
                }
    
                htmlContent += `
                            </tbody>
                        </table>
                    </div>
                `;
    
                // Additional Listing Agents Section
                htmlContent += `
                    <div class="additional-listing-agents mt-3">
                        <h4>Additional Listing Agents</h4>
                        <ul class="list-group">
                `;
    
                if (response.additional_listing_agents.length > 0) {
                    response.additional_listing_agents.forEach(agent => {
                        htmlContent += `
                            <li class="list-group-item">
                                <h5 style="text-decoration: underline !important;">Position : ${agent.position}</h5>
                                <p>Name : ${agent.fullname}</p>
                            </li>
                        `;
                    });
                } else {
                    htmlContent += `<li class="list-group-item text-center">No additional listing agents available</li>`;
                }
    
                htmlContent += `
                        </ul>
                    </div>
                `;
    
                // Investment Highlights Section
                htmlContent += `
                    <div class="investment-highlights mt-3">
                        <h4>Investment Highlights</h4>
                        <ul class="list-group">
                `;
    
                if (response.investment_highlights.length > 0) {
                    response.investment_highlights.forEach(highlight => {
                        htmlContent += `
                            <li class="list-group-item">
                                <h5 style="text-decoration: underline !important;">${highlight.title}</h5>
                                <p>${highlight.content}</p>
                            </li>
                        `;
                    });
                } else {
                    htmlContent += `<li class="list-group-item text-center">No investment highlights available</li>`;
                }
    
                htmlContent += `
                        </ul>
                    </div>
                `;
    
                // Display the formatted content in the #displayDetails div
                $("#displayForLeaseDetails").html(htmlContent);
                $("#propertyTitle").html(`
                    <h3><i class="fa fa-map-pin"></i> ${property_name}</h3><br/>
                    <span>${location}</span>
                `);
    
                // Show the modal
                $("#propertyForLeaseDetails").modal("show");

                $("#leasing-units-sortable").sortable({
                    placeholder: "ui-state-highlight",
                    update: function(event, ui) {
                        let order = $(this).sortable('toArray', { attribute: 'data-id' });
                
                        $.ajax({
                            url: '/admin/propertyforleasemasterlist/updateOrder',
                            type: 'POST',
                            data: { order: order },
                            success: function(response) {
                                if (response.status !== 'success') {
                                    // Show error pop-up only if the update was not successful
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Failed to update the order on the server.',
                                    });
                                }
                            },
                            error: function() {
                                // Show error pop-up for AJAX errors
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Failed to update the order.',
                                });
                            }
                        });
                    }
                });                
            },
            error: function () {
                console.error("Error fetching data");
            }
        });
    });    
    
    $(document).on('click', '.delete-unit-btn', function () {
        let unitId = $(this).data('id'); // Get the ID of the leasing unit
        let rowToDelete = $(this).closest('tr'); // Get the table row for the clicked delete button
    
        // Trigger SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this leasing unit?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, send an AJAX request to delete the leasing unit
                $.ajax({
                    type: "POST",
                    url: "/admin/propertyforleasemasterlist/deleteLeasingUnit", // Your backend URL to handle the delete
                    data: { id: unitId }, // Send the ID of the unit to be deleted
                    success: function (response) {
                        if (response.success) {
                            // Remove the row from the table
                            rowToDelete.remove();
    
                            // Show success message using SweetAlert2
                            Swal.fire(
                                'Deleted!',
                                'The leasing unit has been deleted.',
                                'success'
                            );
                        } else {
                            // Show error message using SweetAlert2
                            Swal.fire(
                                'Error!',
                                'Failed to delete the leasing unit. Please try again.',
                                'error'
                            );
                        }
                    },
                    error: function () {
                        // Show error message using SweetAlert2
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the leasing unit.',
                            'error'
                        );
                    }
                });
            }
        });
    });
          
    $(document).on('click', '.delete-image-btn', function (event) {
        event.preventDefault(); // Prevent default action
        event.stopPropagation(); // Stop event from bubbling up

        var imageId = $(this).data('id');
        var button = this;
        
        deleteImage(imageId, button);
    });       
    // Function to delete an image
    function deleteImage(imageId, button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/propertyforleasemasterlist/deleteImage/' + imageId,
                    method: 'DELETE',
                    success: function (response) {
                        if (response.status === 'success') {
                            // Remove the carousel item
                            $(button).closest('.carousel-item').remove();
    
                            // If the deleted item was active, make the first item active
                            if ($(button).closest('.carousel-item').hasClass('active')) {
                                $('.carousel-item').first().addClass('active');
                            }
    
                            // Update the indicators
                            $('.carousel-indicators li').each(function (index) {
                                $(this).attr('data-slide-to', index);
                            });
    
                            $('.carousel-indicators li').first().addClass('active');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong with the request!',
                        });
                    }
                });
            }
        });
    }

    // Initialize jQuery UI sortable on the preview container
    previewContainer.sortable({
        placeholder: 'sortable-placeholder',
        stop: function (event, ui) {
            updateImageOrder();
        }
    });

    // Handle drag and drop events
    dropZone.on('click', (e) => {
        if (!$(e.target).hasClass('remove-btn') && e.target !== inputFile[0]) {
            inputFile.click();  // Trigger file input click only if the target is not the input field itself
        }
    });

    dropZone.on('dragover', (e) => {
        e.preventDefault();
        dropZone.addClass('dragover');
    });

    dropZone.on('dragleave', () => dropZone.removeClass('dragover'));

    dropZone.on('drop', (e) => {
        e.preventDefault();
        dropZone.removeClass('dragover');
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    // Handle input change
    inputFile.on('change', () => handleFiles(inputFile[0].files));

    // Handle files and generate previews within the drop zone
    function handleFiles(selectedFiles) {
        Array.from(selectedFiles).forEach((file, index) => {
            files.push(file);
            const fileReader = new FileReader();
            fileReader.onload = (e) => {
                const previewItem = $(`
                    <div class="preview-item">
                        <img src="${e.target.result}" alt="${file.name}" />
                        <span class="remove-btn">&times;</span>
                    </div>
                `);
                previewContainer.append(previewItem);

                // Remove image on clicking delete button
                previewItem.find('.remove-btn').on('click', function () {
                    const itemIndex = $(this).parent().index();
                    files.splice(itemIndex, 1);
                    $(this).parent().remove();
                    updateImageOrder();
                });
            };
            fileReader.readAsDataURL(file);
        });
    }

    // Function to update the image order based on their position in the DOM
    function updateImageOrder() {
        const orderedFiles = [];
        previewContainer.find('.preview-item').each(function (index) {
            const itemIndex = $(this).index();
            orderedFiles.push(files[itemIndex]);
        });
        files = orderedFiles;
    }

    $(document).on('click', '.edit-unit-btn', function () {
        let unitId = $(this).data("id");
        $("#propertyForLeaseDetails").modal("hide");
        console.log(unitId);
        $.ajax({
            type: "GET",
            url: "/admin/propertyforleasemasterlist/getLeasingUnitDetails", // Update this URL to the appropriate endpoint
            data: { unitId: unitId },
            success: function (response) {
                console.log(response);
                let leasingUnit = response.data;

                // Populate the modal fields with the response data
                $("#leasing_unit_id").val(leasingUnit.leasing_unit_id);
                $("#edit_property_id").val(leasingUnit.property_id);
                $("#edit_unit_number").val(leasingUnit.unit_number);
                $("#edit_cam").val(leasingUnit.cam);
                $("#edit_leasing_rental_rate").val(leasingUnit.leasing_rental_rate);
                $("#edit_space_available").val(leasingUnit.space_available);
                $("#edit_space_use").val(leasingUnit.space_use);

                $("#edit_preview-container").html('');

                // Display gallery images
                if (response.gallery && response.gallery.length > 0) {
                    response.gallery.forEach(function (image) {
                        let imagePreview = `
                            <div class="preview-item" data-image-id="${image.leasing_gallery_id}">
                                <img src="/${image.location}" class="img-thumbnail" alt="${image.location}">
                                <span class="remove-btn">&times;</span>
                            </div>`;
                        $("#edit_preview-container").append(imagePreview);
                    });
                } else {
                    $("#edit_preview-container").append('<p>No images available.</p>');
                }
                // Show the modal
                $("#editLeasingUnitsModal").modal("show");
            },
            error: function () {
                console.error("Error fetching leasing unit details");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to fetch leasing unit details.',
                });
            }
        });
    });

    // Initialize sortable functionality for preview container
    previewContainer2.sortable({
        placeholder: 'sortable-placeholder',
        stop: function (event, ui) {
            updateImageOrder2();
        }
    });

    // Handle click events on the drop zone (for opening the file input)
    dropZone2.on('click', (e) => {
        if (!$(e.target).hasClass('remove-btn') && e.target !== inputFile2[0]) {
            inputFile2.click();  // Trigger file input click only if the target is not the input field itself
        }
    });

    // Handle drag over events (when dragging over the drop zone)
    dropZone2.on('dragover', (e) => {
        e.preventDefault();  // Prevent default behavior to allow drop
        dropZone2.addClass('dragover');
    });

    // Handle drag leave event (when dragging leaves the drop zone)
    dropZone2.on('dragleave', () => dropZone2.removeClass('dragover'));

    // Handle drop events (when files are dropped into the drop zone)
    dropZone2.on('drop', (e) => {
        e.preventDefault();  // Prevent default behavior to handle files
        dropZone2.removeClass('dragover');
        handleFiles2(e.originalEvent.dataTransfer.files);  // Pass dropped files to handler
    });

    // Handle input file change (when files are selected via the input field)
    inputFile2.on('change', () => handleFiles2(inputFile2[0].files));

    // Handle files and generate previews within the drop zone
    function handleFiles2(selectedFiles2) {
        Array.from(selectedFiles2).forEach((file, index) => {
            files.push(file);  // Add the selected file to the global 'files' array
            const fileReader2 = new FileReader();
    
            fileReader2.onload = (e) => {
                // Create preview item for each file
                const previewItem2 = $(`
                    <div class="preview-item">
                        <img src="${e.target.result}" alt="${file.name}" />
                        <span class="remove-btn">&times;</span>
                    </div>
                `);
    
                previewContainer2.append(previewItem2);  // Append the preview item to the container
    
                // Automatically upload the file to the server
                uploadFileToServer(file);
            };
    
            fileReader2.readAsDataURL(file);  // Read the file as a Data URL
        });
    }
    
    // Function to upload file via AJAX
    function uploadFileToServer(file) {
        const formData = new FormData();
        formData.append('file', file);  // Append the file to FormData
        formData.append('leasing_unit_id', $('#leasing_unit_id').val());  // Add additional data if needed (e.g., leasing unit ID)
    
        $.ajax({
            url: '/admin/propertyforleasemasterlist/uploadLeasingImage',  // Server-side endpoint to handle file upload
            type: 'POST',
            data: formData,
            processData: false,  // Do not process the data as query string
            contentType: false,  // Let the browser set the content type (multipart/form-data)
            success: function(response) {
                if (response.success) {
                    console.log('File uploaded successfully');
                    loadImages();
                } else {
                    console.error('File upload failed:', response.message);
                }
            },
            error: function() {
                console.error('Error uploading file');
            }
        });
    }

    function loadImages() {
        const leasingUnitId = $('#leasing_unit_id').val();
    
        $.ajax({
            url: '/admin/propertyforleasemasterlist/getLeasingImages',  // Endpoint to fetch images from the server
            type: 'GET',
            data: { leasing_unit_id: leasingUnitId },  // Send leasing_unit_id as query parameter
            success: function(response) {
                if (response.success) {
                    // Clear the existing content of the preview container
                    previewContainer2.empty();
    
                    // Loop through the images and append them to the preview container
                    response.images.forEach((image) => {
                        const previewItem2 = $(`
                            <div class="preview-item" data-image-id="${image.leasing_gallery_id}">
                                <img src="/${image.location}" alt="Image Preview" />
                                <span class="remove-btn">&times;</span>
                            </div>
                        `);
    
                        previewContainer2.append(previewItem2);  // Append the preview item to the container
                    });
                } else {
                    console.error('Failed to load images:', response.message);
                }
            },
            error: function() {
                console.error('Error loading images');
            }
        });
    }

    // Use event delegation for dynamically added remove buttons
    $(document).on('click', '#edit_preview-container .remove-btn', function () {
        const itemIndex = $(this).parent().index();  // Get the index of the item
        const imageId = $(this).parent().data('image-id');  // Get the image ID from the data attribute
    
        // Confirm deletion with SweetAlert2
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to delete the image from the server and database
                $.ajax({
                    type: "POST",
                    url: "/admin/propertyforleasemasterlist/deleteImageLeasing", // Update with your actual endpoint
                    data: { imageId: imageId },
                    success: function (response) {
                        if (response.success) {
                            // Remove the file from the files array
                            files.splice(itemIndex, 1);  // Remove file from the global 'files' array
    
                            // Remove the preview item from the DOM
                            $(`#edit_preview-container .preview-item[data-image-id="${imageId}"]`).remove();
    
                            // Update the image order
                            updateImageOrder2();
    
                            // Show success notification
                            Swal.fire(
                                'Deleted!',
                                'The image has been deleted.',
                                'success'
                            );
                        } else {
                            // Handle error from server
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete the image.',
                            });
                        }
                    },
                    error: function () {
                        // Handle AJAX error
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            }
        });
    });    

    // Function to update the image order based on their position in the DOM
    function updateImageOrder2() {
        let orderedFiles2 = [];
        previewContainer2.find('.preview-item').each(function (index) {
            let imageId = $(this).data('image-id'); // Assuming each preview item has a data attribute with the image ID
            orderedFiles2.push({
                id: imageId,
                order: index + 1 // Store the new order (1-based index)
            });
        });
    
        // Send the new order to the server via AJAX
        $.ajax({
            type: "POST",
            url: "/admin/propertyforleasemasterlist/updateImageOrder", // Update with your actual endpoint
            data: { order: orderedFiles2 },
            success: function(response) {
                if (response.success) {
                    console.log("Image order updated successfully.");
                } else {
                    console.error("Error updating image order in the database.");
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'There was an error updating the image order.',
                    });
                }
            },
            error: function() {
                console.error("Error sending AJAX request to update image order.");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update image order.',
                });
            }
        });
    }    

    $('#editLeasingUnits').on('click', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior
    
        // Collect form data
        var property_id = $('#edit_property_id').val();
        var unit_number = $('#edit_unit_number').val();
        var cam = $('#edit_cam').val();
        var leasing_rental_rate = $('#edit_leasing_rental_rate').val();
        var space_available = $('#edit_space_available').val();
        var space_use = $('#edit_space_use').val();
    
        // Check if any field is empty (simple validation)
        if (!property_id || !unit_number || !cam || !leasing_rental_rate || !space_available || !space_use) {
            // Show SweetAlert2 error message
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields before submitting.',
            });
            return; // Stop the form submission
        }
    
        // Create FormData object and collect all form data
        var formData = new FormData($('#editLeasingUnitsForm')[0]); // Collect the form data, including file
    
        $.ajax({
            url: '/admin/propertyforleasemasterlist/editLeasingUnit', // Adjust the URL based on your backend route
            type: 'POST',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function (response) {
                if (response.success) {
                    // Close the modal on success and show a success message with SweetAlert2
                    $('#editLeasingUnitsModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message, // Use the message returned by the server
                    });
                } else {
                    // Show SweetAlert2 error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message, // Use the message returned by the server
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle AJAX errors here (e.g., network/server issues)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            }
        });
    });  
});