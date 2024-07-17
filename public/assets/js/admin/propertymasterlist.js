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
                let imageUrl = response.backgroundimage; // Assuming you have an image URL property
                let property_name = response.property_name; // Assuming you have an image URL property
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
    
                // Format the content as HTML using template literals
                let htmlContent = `
                    <div class="book-layout">
                        <img src="/${imageUrl}" class="book-cover" alt="Book Cover" style="width: 100%;">
                        <div class="property-details mt-3">
                            <div>
                                <p><span class="font-weight-bold">Listing Agent</span>: ${fullname}</p>
                            </div>
                            <div class="content mt-3">
                                <ul class="list-group">
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Real Estate Type</span>: ${real_estate_type}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Price</span>: ${price}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>States</span>: ${state_name}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>City</span>: ${cityname}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Zip Code</span>: ${zipcode}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Cap Rate</span>: ${caprate}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Tenancy</span>: ${tenancy}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Building Size</span>: ${buildingsize}</p></li>
                                    <li class="list-group-item"><span class="font-weight-bold"><p>Year Built</span>: ${yearbuilt}</p></li>
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
});
