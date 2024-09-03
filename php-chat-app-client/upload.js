document.getElementById('uploadForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the file input
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];

    // Prepare FormData object
    var formData = new FormData();
    formData.append('file', file);

    // Create XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'insert_draft.php', true);

    // Set up a handler for the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('status').innerHTML = 'File uploaded successfully!';
        } else {
            document.getElementById('status').innerHTML = 'Error uploading file!';
        }
    };

    // Send the request
    xhr.send(formData);
});
