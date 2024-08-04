$(document).ready(function() {
    let existingFiles = [];
    let selectedFiles = [];

    $('#editproperty').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

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

        let existingFilePromises = [];

        document.querySelectorAll('.existing-image').forEach(function(element, index) {
            var fileName = element.dataset.filename;
            var filePath = element.dataset.filepath;
            var sequenceNumber = index + 1; // Sequence based on position
        
            let fetchPromise = fetch(filePath)
                .then(response => response.blob())
                .then(blob => {
                    var file = new File([blob], fileName, { type: blob.type });
                    formData.append('files[]', file);
                });
        
            existingFilePromises.push(fetchPromise);
        });

        // Wait for all existing files to be added to formData
        Promise.all(existingFilePromises).then(() => {
            // Log files before AJAX call
            console.log("Selected Files:", selectedFiles);
            console.log("Existing Files:", existingFiles);

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
                    console.error(xhr.responseText);
                }
            });
        }).catch(error => {
            console.error('Error processing files:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while processing files. Please try again.',
            });
        });
    });

    function initializeFileSequences() {
        $('#fileList .file-wrapper').each(function(index) {
            $(this).data('index', index);
            $(this).attr('data-index', index);

            const sequenceNumber = $(this).find('.sequence-number');
            if (sequenceNumber.length) {
                sequenceNumber.text(`#${index + 1}`);
            } else {
                $('<span class="sequence-number">#' + (index + 1) + '</span>').appendTo($(this));
            }
        });
    }

    initializeFileSequences();

    $('#fileList').sortable({
        update: function(event, ui) {
            const sortedIds = $('#fileList .file-wrapper').map(function() {
                return $(this).data('index');
            }).get();

            existingFiles.forEach(file => {
                file.index = sortedIds.indexOf(file.index);
            });

            $('#fileList .file-wrapper').each(function(index) {
                $(this).data('index', index);
                $(this).attr('data-index', index);
                $(this).find('.sequence-number').text(`#${index + 1}`);
            });

            updateFileSequence();
        }
    });

    function updateFileSequence() {
        $('#fileList .file-wrapper').each(function(index) {
            $(this).data('index', index);
            $(this).attr('data-index', index);
            $(this).find('.sequence-number').text(`#${index + 1}`);
        });
    }

    $('#fileList').sortable('refresh'); // Refresh sortable after initialization

    // Initialize existing files with sequence
    $('#fileList .file-wrapper[data-type="existing"]').each(function(index) {
        $(this).data('index', index);
        $(this).attr('data-index', index);

        const sequenceNumber = $(this).find('.sequence-number');
        if (sequenceNumber.length) {
            sequenceNumber.text(`#${index + 1}`);
        } else {
            // Create a new sequence number element if it doesn't exist
            $('<span class="sequence-number">#' + (index + 1) + '</span>').appendTo($(this));
        }

        existingFiles.push({
            id: $(this).data('id'),
            index: index,
            element: $(this)
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
        Array.from(files).forEach((file) => {
            if (acceptedFileTypes.includes(file.name.split('.').pop())) {
                const fileWrapper = document.createElement('div');
                fileWrapper.className = 'file-wrapper';
                fileWrapper.dataset.index = selectedFiles.length + existingFiles.length;
                fileWrapper.dataset.type = 'new';
    
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-preview';
                    fileWrapper.appendChild(img);
    
                    const sequenceNumber = document.createElement('span');
                    sequenceNumber.className = 'sequence-number';
                    sequenceNumber.textContent = `#${fileWrapper.dataset.index + 1}`;
                    fileWrapper.appendChild(sequenceNumber);
    
                    const deleteBtn = document.createElement('span');
                    deleteBtn.className = 'delete-btn-preview';
                    deleteBtn.innerHTML = '&times;';
                    deleteBtn.onclick = function() {
                        fileList.removeChild(fileWrapper);
                        selectedFiles = selectedFiles.filter(f => f !== file);
                        updateFileSequence();
                    };
                    fileWrapper.appendChild(deleteBtn);
    
                    fileList.appendChild(fileWrapper);
    
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'files[]';
                    fileInput.style.display = 'none';
                    fileInput.dataset.index = fileWrapper.dataset.index;
                    fileInput.dataset.name = file.name;
                    fileWrapper.appendChild(fileInput);
    
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                };
                reader.readAsDataURL(file);
    
                selectedFiles.push(file);
            } else {
                alert("Unsupported file type.");
            }
        });

        makeSortable();
        updateFileSequence();
        console.log("Selected Files after handling new files:", selectedFiles);
    } 
    
    function makeSortable() {
        $('#fileList').sortable({
            update: function(event, ui) {
                const sortedIds = $('#fileList .file-wrapper').map(function() {
                    return $(this).data('index');
                }).get();

                existingFiles.forEach(file => {
                    file.index = sortedIds.indexOf(file.index);
                });

                $('#fileList .file-wrapper').each(function(index) {
                    $(this).data('index', index);
                    $(this).attr('data-index', index);
                    $(this).find('.sequence-number').text(`#${index + 1}`);
                });

                updateFileSequence();
            }
        });
    }

    function initializeFileList() {
        $('#fileList .file-wrapper').each(function(index) {
            $(this).data('index', index);
            $(this).attr('data-index', index);
        });
    }

    initializeFileList();  

    function updateFileSequence() {
        let allFiles = $('#fileList .file-wrapper').toArray();
        
        allFiles.forEach((fileWrapper, index) => {
            $(fileWrapper).data('index', index);
            $(fileWrapper).attr('data-index', index);
    
            const sequenceNumber = $(fileWrapper).find('.sequence-number');
            if (sequenceNumber.length) {
                sequenceNumber.text(`#${index + 1}`);
            } else {
                $('<span class="sequence-number">#' + (index + 1) + '</span>').appendTo($(fileWrapper));
            }
        });
    
        existingFiles = $('#fileList .file-wrapper[data-type="existing"]').map(function() {
            return {
                id: $(this).data('id'),
                index: Number($(this).data('index')), // Ensure this is a number
                element: $(this)
            };
        }).get();
        
        selectedFiles = $('#fileList .file-wrapper[data-type="new"]').map(function() {
            return selectedFiles[Number($(this).data('index')) - existingFiles.length];
        }).get();
    
        console.log("Existing Files after updating sequence:", existingFiles);
        console.log("Selected Files after updating sequence:", selectedFiles);
    }     

    makeSortable();

    $("#fileList").on("click", ".delete-btn-preview", function () {
        $(this).parent().remove();
        const indexToRemove = $(this).parent().data('index');

        if ($(this).parent().data('type') === 'existing') {
            existingFiles = existingFiles.filter(file => file.index !== indexToRemove);
        } else {
            selectedFiles = selectedFiles.filter((file, index) => index !== (indexToRemove - existingFiles.length));
        }

        updateFileSequence();
        // Log after deleting a file
        console.log("Existing Files after deletion:", existingFiles);
        console.log("Selected Files after deletion:", selectedFiles);
    });
});
