<!DOCTYPE html>
<html lang="en"data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Generator</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include html2canvas library -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <style>
        #generatedQrCode{
            width:fit-content;
        }
    </style>
</head>
<body class="bg-dark-subtle">
    <div class="container mt-5">
        <h2 class="text-white mb-4">QR Code Generator App using Laravel 10</h2>
        <form id="qrForm" action="{{ route('generate.qr.code') }}" method="post" class="mb-3">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Enter Link or Text:</label>
                <input type="text" id="content" name="content" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Generate QR Code</button>
        </form>

        @if (isset($qrCode))
            <div class="card mb-3">
                <div class="card-body" id="generatedQrCode">
                    {!! $qrCode !!}
                </div>
            </div>
            <button onclick="convertToImage()" class="btn btn-success btn-sm">Download as Image</button>
        @endif

    </div>

    <script>
        function convertToImage() {
            // Get the generatedQrCode div element
            var element = document.getElementById('generatedQrCode');

            // Use html2canvas to capture the content and convert it to a canvas
            html2canvas(element).then(function(canvas) {
                // Create a temporary link and trigger the download
                var a = document.createElement('a');
                document.body.appendChild(a);
                a.href = canvas.toDataURL('image/png');
                a.download = 'generatedQrCode.png';
                a.click();
                document.body.removeChild(a);

                // Reset the input field value
                document.getElementById('content').value = '';

                // Clear the content of the generatedQrCode div
                element.innerHTML = '';

                // Hide the download button
                document.getElementById('downloadButton').style.display = 'none';

                // Reset the form (if there are other form fields)
                document.getElementById('qrForm').reset();
            });
        }
    </script>
</body>
</html>
