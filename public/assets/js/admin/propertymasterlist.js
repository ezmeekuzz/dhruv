$(document).ready(function () {
    var table = $('#propertymasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/propertymasterlist/getData",
            "type": "GET"
        },
        "columns": [
            { "data": "property_name" },
            { "data": "real_estate_type" },
            { "data": "property_type" },
            { "data": "fullname" },
            { "data": "price" },
            { "data": "publishstatus" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<a href="/admin/edit-property/${row.property_id}" title="Edit" class="edit-btn" data-id="${row.property_id}" style="color: blue;"><i class="fa fa-edit" style="font-size: 18px;"></i></a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.property_id}" style="color: red;"><i class="fa fa-trash" style="font-size: 18px;"></i></a>`;
                }
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').attr('data-id', data.property_id);
            $(row).find('td:not(:last-child)').addClass('propertyDetails');
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
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
                    url: '/admin/propertymasterlist/delete/' + id,
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
    $(document).on('click', '.propertyDetails', function () {
        let propertyId = $(this).data("id");
    
        $.ajax({
            type: "GET",
            url: "/admin/propertymasterlist/propertyDetails",
            data: { propertyId: propertyId },
            success: function (response) {
                // Access specific properties from the response object
                let fullname = response.fullname;
                let images = response.property_galleries; // Assuming `response.images` is an array of image URLs
                let property_name = response.property_name;
                let location = response.location;
                let real_estate_type = response.real_estate_type;
                let price = response.price;
                let state_name = response.state_name;
                let cityname = response.cityname;
                let zipcode = response.zipcode;
                let caprate = response.caprate;
                let tenancy = response.tenancy;
                let buildingsize = response.buildingsize;
                let yearbuilt = response.yearbuilt;
        
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
                            <li data-target="#carouselExampleIndicators" data-slide-to="firstSlide" class=""></li>
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
                                <li class="list-group-item"><span class="font-weight-bold">Real Estate Type</span>: ${real_estate_type}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Price</span>: ${price}</li>
                                <li class="list-group-item"><span class="font-weight-bold">States</span>: ${state_name}</li>
                                <li class="list-group-item"><span class="font-weight-bold">City</span>: ${cityname}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Zip Code</span>: ${zipcode}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Cap Rate</span>: ${caprate}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Tenancy</span>: ${tenancy}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Building Size</span>: ${buildingsize}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Year Built</span>: ${yearbuilt}</li>
                                <li class="list-group-item"><span class="font-weight-bold">Offering Memorandum</span>: <a href="/${response.offering_memorandum}" target="_blank" class="btn btn-primary"><i class="fa fa-share"></i> Open</a></li>
                            </ul>
                        </div>
                        <div class="additional-listing-agents mt-3">
                            <h4>Additional Listing Agents</h4>
                            <ul class="list-group">
                `;
        
                // Append additional listing agents
                response.additional_listing_agents.forEach(agent => {
                    htmlContent += `
                        <li class="list-group-item">
                            <h5 style="text-decoration: underline !important;">Position : ${agent.position}</h5>
                            <p>Name : ${agent.fullname}</p>
                        </li>
                    `;
                });
        
                htmlContent += `
                            </ul>
                        </div>
                        <div class="investment-highlights mt-3">
                            <h4>Investment Highlights</h4>
                            <ul class="list-group">
                `;
        
                // Append investment highlights
                response.investment_highlights.forEach(highlight => {
                    htmlContent += `
                        <li class="list-group-item">
                            <h5 style="text-decoration: underline !important;">${highlight.title}</h5>
                            <p>${highlight.content}</p>
                        </li>
                    `;
                });
        
                htmlContent += `
                            </ul>
                        </div>
                    </div>
                `;
        
                // Display the formatted content in the #displayDetails div
                $("#displayDetails").html(htmlContent);
                $("#propertyTitle").html(`
                    <h3><i class="fa fa-map-pin"></i> ${property_name}</h3><br/>
                    <span>${location}</span>
                `);
        
                // Show the modal
                $("#propertyDetails").modal("show");
            },
            error: function () {
                console.error("Error fetching data");
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
                    url: '/admin/propertymasterlist/deleteImage/' + imageId,
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