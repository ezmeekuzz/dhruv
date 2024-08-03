$(document).ready(function() {
    let selectedFiles = []; // Global variable to store selected files

    $('#addproperty').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Perform client-side validation
        var requiredFields = [
            'propertyname', 'real_estate_type', 'property_type_id', 'listing_agent_id',
            'price', 'price_per_sf', 'caprate', 'state_id', 'city_id', 'zipcode', 'tenancy',
            'buildingsize', 'yearbuilt', 'location', 'backgroundimage'
        ];
        var isValid = true;

        requiredFields.forEach(function(field) {
            if (!formData.get(field)) {
                isValid = false;
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

        // Append the selected files to formData
        /*for (let i = 0; i < selectedFiles.length; i++) {
            formData.append('files[]', selectedFiles[i]);
        }*/
        selectedFiles.forEach((file, index) => {
            formData.append(`files[]`, file);
            formData.append(`order[]`, index); // Send the order with each file
        });

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/addproperty/insert',
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
                    $('#addproperty')[0].reset();
                    $('.chosen-select').trigger('chosen:updated');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    $('.investmenthighlights').empty();
                    $('#fileList').empty();
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
                console.error(xhr.responseText);
            }
        });
    });

    $('#state_id').on('change', function() {
        let stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: `/admin/addproperty/getCities/${stateId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let citySelect = $('#city_id');
                    citySelect.empty();
                    citySelect.append('<option hidden></option><option disabled></option>');
                    if (data && data.length > 0) {
                        $.each(data, function(index, city) {
                            citySelect.append(`<option value="${city.city_id}">${city.cityname}</option>`);
                        });
                    }
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

    $('#searchlistingagent').on('keyup', filter);
    filter();

    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const fileSelectBtn = document.getElementById('fileSelectBtn');
    const fileList = document.getElementById('fileList');

    const acceptedFileTypes = ['png', 'jpg', 'webp', 'jpeg', 'PNG', 'JPG', 'WEBP', 'JPEG'];

    uploadArea.addEventListener('dragover', function(event) {
        event.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function(event) {
        event.preventDefault();
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function(event) {
        event.preventDefault();
        uploadArea.classList.remove('drag-over');
        handleFiles(event.dataTransfer.files);
    });

    fileSelectBtn.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        handleFiles(fileInput.files);
    });

    function handleFiles(files) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = ''; // Clear previous previews
        selectedFiles = []; // Reset the selected files array
    
        Array.from(files).forEach((file, index) => {
            const fileWrapper = document.createElement('div');
            fileWrapper.className = 'file-wrapper';
            fileWrapper.dataset.index = index;
    
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-preview';
                fileWrapper.appendChild(img);
    
                const deleteBtn = document.createElement('span');
                deleteBtn.className = 'delete-btn-preview';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.onclick = function() {
                    fileList.removeChild(fileWrapper);
                    selectedFiles.splice(index, 1); // Remove from array
                    updateFileSequence(); // Update sequence after removal
                };
                fileWrapper.appendChild(deleteBtn);
    
                fileList.appendChild(fileWrapper);
            };
            reader.readAsDataURL(file);
    
            selectedFiles.push(file); // Add the file to the selectedFiles array
        });
    
        makeSortable();
    }
    
    function makeSortable() {
        $("#fileList").sortable({
            update: function(event, ui) {
                updateFileSequence();
            }
        }).disableSelection();
    }
    
    function updateFileSequence() {
        const updatedFiles = [];
        $('#fileList .file-wrapper').each(function() {
            const index = $(this).data('index');
            updatedFiles.push(selectedFiles[index]);
        });
        selectedFiles = updatedFiles;
    }
});

function addinvestmenthighlight() {
    var elem = '<div class="InvestmentHighlightLists"><div class="form-group"><label for="content" style="float: left;">Investment Highlight</label><div style="float: right;"><a href="javascript:void(0);" onclick="addinvestmenthighlight();" title="Add Investment Highlight"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a><a href="javascript:void(0);" style="color: red; font-size: 18px;" class="remove-investment-highlight"><i class="fa fa-trash"></i></a></div><input type="text" name="title[]" id="title" class="form-control mb-3" placeholder="Enter Title"><textarea class="form-control" id="content" name="content[]" placeholder="Content" style="resize: none; min-height: 80px;"></textarea></div></div>';
    $('.investmenthighlights').append(elem);
}
$('.investmenthighlights').on('click', '.remove-investment-highlight', function() {
    $(this).closest('.InvestmentHighlightLists').remove();
});
