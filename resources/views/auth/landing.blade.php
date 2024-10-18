<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Student App - Login</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- font-awesome icons -->
        <script src="https://kit.fontawesome.com/2d49de291b.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="min-w-screen min-h-screen bg-gradient-to-r from-gray-800 to-gray-400 flex items-center justify-center px-5 py-5">
            <div class="bg-gray-100 text-gray-500 rounded-3xl shadow-xl w-full overflow-hidden" style="max-width:1000px">
                <div class="md:flex w-full">
                    <div class="hidden md:flex w-1/2 bg-white py-10 px-10 justify-center">
                        <div>                            
                            <img src="{{ asset('assets/form1.png') }}" alt="form">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 py-10 px-5 md:px-10">
                        <div class="flex items-center justify-center">
                            <img class="justify-center" width="50px" height="50px" src="{{ asset('assets/logo.png') }}" alt="logo"/>
                        </div>
                        <h2 class="mt-4 text-center text-3xl font-bold tracking-tight text-gray-900">Scan Your QR</h2>
                        @if (session('status'))
                            <div id="statusAlert" class="text-black m-2 p-4 bg-green-200">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('err'))
                            <div id="errorAlert" class="text-black m-2 p-4 bg-red-200">
                                {{ session('err') }}
                            </div>
                        @endif
                        <div id="reader" width="600px"></div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-gray-500 text-white py-2">
            <div class="container mx-auto px-4 text-center">
            <p>Developed By <a href="https://bitware.global/" class="text-white" target="_blank">www.bitware.global</a></p>
            </div>
        </footer>

        <!-- Include html5-qrcode library -->
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            let isScanned = false; // Flag to prevent multiple scans

            function onScanSuccess(decodedText, decodedResult) {
                if (isScanned) return; // Prevent further execution if already scanned

                // Set the flag to true to prevent further scans
                isScanned = true;

                // Handle the scanned code
                console.log(`Code matched = ${decodedText}`, decodedResult);

                // Redirect to the QR code's URL
                window.location.href = decodedText;

                // Clear the QR code scanner
                html5QrcodeScanner.clear().catch(error => {
                    console.error("Failed to clear the QR code scanner: ", error);
                });
            }

            function onScanFailure(error) {
                // Handle scan failure
                console.warn(`Code scan error = ${error}`);
            }

            // Delay the initialization of the QR code scanner by 10 seconds
            setTimeout(() => {
                var statusAlert = document.getElementById('statusAlert');
                if (statusAlert) {
                    statusAlert.style.display = 'none';
                }
                var errorAlert = document.getElementById('errorAlert');
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
                const html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }, 5000);
        </script>
    </body>
</html>