$(document).ready(function () {
    var table = $('#listingagentmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/listingagentmasterlist/getData",
            "type": "GET"
        },
        "columns": [
            { "data": "fullname" },
            { "data": "email" },
            { "data": "licenseno" },
            { "data": "phonenumber" },
            { "data": "mobilenumber" },
            { "data": "position" },
            {
                "data": "profileimage",
                "render": function (data, type, row) {
                    return `<img src="/${data}" alt="Profile Image" style="max-width: 50px; max-height: 50px;">`;
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<a href="/admin/edit-listing-agent/${row.listing_agent_id}" title="Edit" class="edit-btn" data-id="${row.listing_agent_id}" style="color: blue;"><i class="fa fa-edit" style="font-size: 18px;"></i></a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.listing_agent_id}" style="color: red;"><i class="fa fa-trash" style="font-size: 18px;"></i></a>`;
                }
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.listing_agent_id);
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
                    url: '/admin/listingagentmasterlist/delete/' + id,
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
});
