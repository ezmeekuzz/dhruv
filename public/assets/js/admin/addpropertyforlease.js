$(document).ready(function() {
    let selectedFiles = []; // Global variable to store selected files

    $('#addpropertyforlease').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Perform client-side validation
        var requiredFields = [
            'propertyname', 'anchor_tenant', 'space_id', 'listing_agent_id',
            'state_id', 'city_id', 'zipcode', 'buildingsize', 'yearbuilt', 'location',
            'leasestructure', 'rental_rate', 'size_sf', 'addt', 'starting_sf_yr', 'ending_sf_yr', 'sf_yr',
            'backgroundimage'
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

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/addpropertyforlease/insert',
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
                    $('#addpropertyforlease')[0].reset();
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

    function handleFiles(files) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = ''; // Clear previous previews
    
        selectedFiles = selectedFiles.concat(Array.from(files));
    
        selectedFiles.forEach((file, index) => {
            const fileWrapper = document.createElement('div');
            fileWrapper.className = 'file-wrapper';
            fileWrapper.dataset.index = index;
    
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-preview';
                fileWrapper.appendChild(img);
    
                const sequenceNumber = document.createElement('span');
                sequenceNumber.className = 'sequence-number';
                sequenceNumber.textContent = `#${index + 1}`;
                fileWrapper.appendChild(sequenceNumber);
    
                const deleteBtn = document.createElement('span');
                deleteBtn.className = 'delete-btn-preview';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.onclick = function() {
                    fileList.removeChild(fileWrapper);
                    selectedFiles = selectedFiles.filter((_, i) => i !== index);
                    updateFileSequence();
                };
                fileWrapper.appendChild(deleteBtn);
    
                fileList.appendChild(fileWrapper);
    
                // Create and append file input field to the fileWrapper
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = 'files[]';
                fileInput.style.display = 'none'; // Hide the file input
                fileInput.dataset.index = index; // Set the data-index attribute
                fileInput.dataset.name = file.name; // Set the data-name attribute
                fileWrapper.appendChild(fileInput);
    
                // Assign image data to the file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            };
            reader.readAsDataURL(file);
        });
    
        makeSortable(); // Initialize sorting functionality
        updateFileSequence(); // Update sequence initially
    }

    function makeSortable() {
        $("#fileList").sortable({
            update: function(event, ui) {
                const newIndex = ui.item.index();
                const oldIndex = ui.item.data('index');
                const movedFile = selectedFiles.splice(oldIndex, 1)[0];
                selectedFiles.splice(newIndex, 0, movedFile);

                updateFileSequence(); // Update index after rearrangement
            }
        }).disableSelection();
    }

    function updateFileSequence() {
        const fileWrappers = document.querySelectorAll('.file-wrapper');
        fileWrappers.forEach((wrapper, index) => {
            wrapper.dataset.index = index;
            const sequenceNumber = wrapper.querySelector('.sequence-number');
            sequenceNumber.textContent = `#${index + 1}`;

            // Update file input data-index
            const fileInput = wrapper.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.dataset.index = index;
            }
        });
    }

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
        // Open file dialog to select files
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.multiple = true;
        fileInput.style.display = 'none';

        fileInput.addEventListener('change', function() {
            handleFiles(fileInput.files);
        });

        fileInput.click();
    });
});

function addinvestmenthighlight() {
    var elem = '<div class="InvestmentHighlightLists"><div class="form-group"><label for="content" style="float: left;">Investment Highlight</label><div style="float: right;"><a href="javascript:void(0);" onclick="addinvestmenthighlight();" title="Add Investment Highlight"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a><a href="javascript:void(0);" style="color: red; font-size: 18px;" class="remove-investment-highlight"><i class="fa fa-trash"></i></a></div><input type="text" name="title[]" id="title" class="form-control mb-3" placeholder="Enter Title"><textarea class="form-control" id="content" name="content[]" placeholder="Content" style="resize: none; min-height: 80px;"></textarea></div></div>';
    $('.investmenthighlights').append(elem);
}
$('.investmenthighlights').on('click', '.remove-investment-highlight', function() {
    $(this).closest('.InvestmentHighlightLists').remove();
});

function initAutocomplete() {
    var locationInput = document.getElementById('location');
    
    // Create the autocomplete object
    var autocomplete = new google.maps.places.Autocomplete(locationInput, {
        types: ['geocode'], // You can restrict to certain types of places like 'establishment' for businesses
        componentRestrictions: { country: "us" } // Restrict results to a specific country (optional)
    });

    // Set the data fields to return when a place is selected
    autocomplete.setFields(['address_components', 'geometry', 'formatted_address']);
    
    // Add a listener to handle when a user selects a place
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            alert("No details available for input: '" + place.name + "'");
            return;
        }
        
        // Optionally, you can use the place details here (e.g., lat/long or address_components)
        console.log('Selected place:', place);
        
        // Update your form fields with the selected location data if needed
        // For example, you can split the address components into other fields
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);
