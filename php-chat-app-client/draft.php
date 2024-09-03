<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>

    <h2>Upload a File</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" id="fileInput" name="file" required><br><br>
    </form>
    
    <button type="submit">Upload File</button>
    <div id="status"></div>

    <script>
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

    </script>
</body>
</html>
