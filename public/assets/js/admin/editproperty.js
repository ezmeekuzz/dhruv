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

        selectedFiles.forEach((file, index) => {
            formData.append(`files[]`, file);
            formData.append(`order[]`, index);
        });

        let existingFilePromises = [];

        document.querySelectorAll('.existing-image').forEach(function(imageElem) {
            var fileName = imageElem.getAttribute('data-filename');
            var filePath = imageElem.getAttribute('data-filepath');

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

    $('#fileList .file-wrapper[data-type="existing"]').each(function() {
        const index = $(this).data('index');
        existingFiles.push({
            id: $(this).data('id'),
            index: index,
            element: $(this)
        });
    });
    
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
        Array.from(files).forEach((file, index) => {
            if (acceptedFileTypes.includes(file.name.split('.').pop())) {
                const fileWrapper = document.createElement('div');
                fileWrapper.className = 'file-wrapper';
                fileWrapper.dataset.index = index + existingFiles.length;
                fileWrapper.dataset.type = 'new';
    
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
                        selectedFiles = selectedFiles.filter((f, i) => i !== index);
                        updateFileSequence();
                    };
                    fileWrapper.appendChild(deleteBtn);
    
                    fileList.appendChild(fileWrapper);
                };
                reader.readAsDataURL(file);
    
                selectedFiles.push(file);
            } else {
                alert("Unsupported file type.");
            }
        });
    
        makeSortable();
        // Log after handling new files
        console.log("Selected Files after handling new files:", selectedFiles);
    }
    
    function makeSortable() {
        $("#fileList").sortable({
            update: function(event, ui) {
                updateFileSequence();
            }
        }).disableSelection();
    }
    
    function updateFileSequence() {
        let updatedExistingFiles = [];
        let updatedSelectedFiles = [];
    
        $('#fileList .file-wrapper').each(function(index) {
            const type = $(this).data('type');
            const originalIndex = $(this).data('index');
    
            if (type === 'existing') {
                updatedExistingFiles.push(existingFiles.find(file => file.index === originalIndex));
            } else {
                updatedSelectedFiles.push(selectedFiles[originalIndex - existingFiles.length]);
            }
    
            $(this).attr('data-index', index);
        });
    
        existingFiles = updatedExistingFiles;
        selectedFiles = updatedSelectedFiles;

        // Log after updating file sequence
        console.log("Existing Files after updating sequence:", existingFiles);
        console.log("Selected Files after updating sequence:", selectedFiles);
    }
    
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
    
    makeSortable();
});
