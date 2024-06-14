<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
</head>
<!-- Include the html5-qrcode.min.js library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<style>
    body {
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 0;
        height: 100vh;
        box-sizing: border-box;
        text-align: center;
        background: rgb(255 255 255 / 66%);
    }
    .container {
        width: 100%;
        max-width: 500px;
        margin: 50px;
    }
    
    /* .container h1 {0
        color: #ffffff;
    }
    
    .section {
        background-color: #ffffff;
        padding: 50px 30px;
        border: 1.5px solid #b2b2b2;
        border-radius: 0.25em;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
    } */
    
    #qr-reader {
        /* padding: 20px !important; */
        border: none !important;
        border-radius: 8px;
    }
    
    #qr-reader img[alt="Info icon"] {
        display: none;
    }
    
    #qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
    }
    
    button {
        padding: 10px 20px;
        border: 1px solid #b2b2b2;
        outline: none;
        border-radius: 0.25em;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
    }
    
    button:hover {
        background-color: #008000;
    }
    
    #html5-qrcode-anchor-scan-type-change {
        text-decoration: none !important;
        color: #1d9bf0;
    }
    
    video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
    }
</style>
<body>
    <div class="container">
        <!-- <h1>Scan QR Codes</h1> -->
        <div id="qr-reader"></div>
    </div>
    <!-- <h1>QR Code Scanner</h1>
    <div id="reader" style="width: 500px;"></div>
    <div id="result">Result will appear here</div> -->

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Handle the result of the scan
            console.log(`Code matched = ${decodedText}`, decodedResult);
            //document.getElementById('result').innerText = `Scanned result: ${decodedText}`;
            // html5QrcodeScanner.clear();
        }

        function onScanFailure(error) {
            // Handle the error scenario
            console.warn(`Code scan error = ${error}`);
        }

        // Initialize the QR code scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { 
                fps: 10, 
                qrbox: 250,
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true // Optional, if you want to enable barcode detection
                },
                facingMode: { exact: "environment" } // This sets the rear camera
            }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
    <script>
        var selectElement = document.getElementById('html5-qrcode-select-camera');
        // Remove all options except the first one
        while (selectElement.options.length > 1) {
            selectElement.remove(1);
        }
    </script>
</body>
</html>