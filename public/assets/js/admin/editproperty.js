$(document).ready(function() {
    let selectedFiles = [];

    // Submit form handler
    $('#editproperty').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Add order_sequence inputs based on the current sequence in the DOM
        $('#fileList .file-wrapper').each(function() {
            let dataIndex = $(this).data('index');
            let hiddenInput = $('<input>').attr({
                type: 'hidden',
                name: 'order_sequence[]',
                value: dataIndex
            });
            formData.append(hiddenInput.attr('name'), hiddenInput.val());

            let fileName = $(this).find('.existing-image').data('filename');
            console.log(`${fileName} => ${dataIndex}`);
        });

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

        // Handle existing files
        let existingFilePromises = [];

        $('#fileList .file-wrapper[data-type="existing"]').each(function() {
            var fileName = $(this).find('.existing-image').data('filename');
            var filePath = $(this).find('.existing-image').data('filepath');

            let fetchPromise = fetch(filePath)
                .then(response => response.blob())
                .then(blob => {
                    var file = new File([blob], fileName, { type: blob.type });
                    formData.append('files[]', file);
                })
                .catch(err => {
                    console.error(`Error fetching file ${fileName}:`, err);
                });

            existingFilePromises.push(fetchPromise);
        });

        // Submit after processing existing files
        Promise.all(existingFilePromises).then(() => {
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
        }).catch(error => {
            console.error('Error processing files:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while processing files. Please try again.',
            });
        });
    });

    // State change handler for loading cities
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

    // File input change handler
    $(document).on('change', '.custom-file-input', function() {
        var file = this.files[0].name;
        $(this).siblings('.custom-file-label').text(file.substring(0, 20));
    });

    // Search filter for listing agent
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

    // Initialize file sequences
    function initializeFileSequences() {
        $('#fileList .file-wrapper').each(function(index) {
            const newIndex = index + 1; // Correcting the index to start from 1
            $(this).data('index', newIndex);
            $(this).attr('data-index', newIndex);

            const sequenceNumber = $(this).find('.sequence-number');
            if (sequenceNumber.length) {
                sequenceNumber.text(`#${newIndex}`);
            } else {
                $('<span class="sequence-number">#' + newIndex + '</span>').appendTo($(this));
            }
        });
    }

    initializeFileSequences();

    // Sortable functionality for file list
    $('#fileList').sortable({
        update: function(event, ui) {
            updateFileSequence();
        }
    }).disableSelection();

    // Update file sequence after sorting or deleting
    function updateFileSequence() {
        $('#fileList .file-wrapper').each(function(index) {
            const newIndex = index + 1; // Correcting the index to start from 1
            $(this).data('index', newIndex);
            $(this).attr('data-index', newIndex);

            const sequenceNumber = $(this).find('.sequence-number');
            sequenceNumber.text(`#${newIndex}`);

            const fileInput = $(this).find('input[type="file"]');
            if (fileInput.length) {
                fileInput.data('index', newIndex - 1); // fileInput index should start from 0 for array submission
            }
        });
    }

    $('#fileList').sortable('refresh');

    // Delete file preview and update sequence
    $('#fileList').on('click', '.delete-btn-preview', function () {
        $(this).parent().remove();
        updateFileSequence();
    });

    // Drag-and-drop file handling
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const fileSelectBtn = document.getElementById('fileSelectBtn');

    if (uploadArea) {
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
    }

    if (fileSelectBtn) {
        fileSelectBtn.addEventListener('click', function() {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.multiple = true;
            fileInput.style.display = 'none';

            fileInput.addEventListener('change', function() {
                handleFiles(fileInput.files);
            });

            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            handleFiles(fileInput.files);
        });
    }

    // Handle files function to display previews and manage sequences
    function handleFiles(files) {
        const fileList = document.getElementById('fileList');
        const existingFileCount = $('#fileList .file-wrapper[data-type="existing"]').length;

        selectedFiles = selectedFiles.concat(Array.from(files));

        selectedFiles.forEach((file, index) => {
            const newIndex = existingFileCount + index + 1;
            const fileWrapper = document.createElement('div');
            fileWrapper.className = 'file-wrapper';
            fileWrapper.dataset.index = newIndex;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-preview';
                fileWrapper.appendChild(img);

                const sequenceNumber = document.createElement('span');
                sequenceNumber.className = 'sequence-number';
                sequenceNumber.textContent = `#${newIndex}`;
                fileWrapper.appendChild(sequenceNumber);

                const deleteButton = document.createElement('button');
                deleteButton.className = 'delete-btn-preview';
                deleteButton.textContent = 'x';
                deleteButton.addEventListener('click', function() {
                    const fileIndex = selectedFiles.indexOf(file);
                    if (fileIndex > -1) {
                        selectedFiles.splice(fileIndex, 1);
                    }
                    fileWrapper.remove();
                    updateFileSequence();
                });
                fileWrapper.appendChild(deleteButton);

                // Create hidden input field for file data
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'file';
                hiddenInput.name = 'files[]';
                hiddenInput.dataset.index = newIndex - 1;
                hiddenInput.dataset.name = file.name;
                hiddenInput.style.display = 'none';

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                hiddenInput.files = dataTransfer.files;

                fileWrapper.appendChild(hiddenInput);
            };
            reader.readAsDataURL(file);
            fileList.appendChild(fileWrapper);
        });
    }

    // Prevent default form submission and alert user
    $('#editproperty').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Form submission is disabled for demo.',
            icon: 'info'
        });
    });
});
