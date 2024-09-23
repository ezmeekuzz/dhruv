$(document).ready(function () {
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
                            <a href="#" title="Add Leasing Units" class="add-leasing-units" data-id="${row.property_id}" style="color: green;"><i class="fa fa-plus-circle" style="font-size: 18px;"></i></a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.property_id}" style="color: red;"><i class="fa fa-trash" style="font-size: 18px;"></i></a>`;
                }
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').addClass('propertyForLeaseDetails');
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
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
        var property_id = $('#property_id').val().trim();
        var unit_number = $('#unit_number').val().trim();
        var leasing_rental_rate = $('#leasing_rental_rate').val().trim();
        var space_available = $('#space_available').val().trim();
        var space_use = $('#space_use').val().trim();
    
        // Check if any field is empty (simple validation)
        if (!property_id || !unit_number || !leasing_rental_rate || !space_available || !space_use) {
            // Show SweetAlert2 error message
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields before submitting.',
            });
            return; // Stop the form submission
        }
    
        // If all fields are filled, proceed with form submission via AJAX
        var formData = new FormData($('#addLeasingUnitsForm')[0]); // Collect the form data, including file
    
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
                                    <th>Rental Rate</th>
                                    <th>Space Available</th>
                                    <th>Space Use</th>
                                    <th>Site Plan Map</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                `;
    
                if (response.leasing_units.length > 0) {
                    response.leasing_units.forEach(unit => {
                        htmlContent += `
                            <tr>
                                <td>${unit.unit_number}</td>
                                <td>${unit.leasing_rental_rate} sq.ft.</td>
                                <td>${unit.space_available}</td>
                                <td>${unit.space_use}</td>
                                <td><img src="/${unit.site_plan_map}" style="width: 100%;" /></td>
                                <td><a href="javascript:void(0);" class="delete-unit-btn" data-id="${unit.leasing_unit_id}"><i class="fa fa-trash" style="color: red; font-size: 18px;"></i></a></td>
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
    
});