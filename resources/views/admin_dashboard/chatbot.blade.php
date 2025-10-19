<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Added CSRF token -->
    <title>UrbanGreen - Chatbot</title>
    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    @vite(['resources/vendor/fontawesome-free/css/all.min.css', 'resources/css/sb-admin-2.min.css'])
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin_dashboard.partials.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('admin_dashboard.partials.topbar')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Espace Vert Chatbot</h1>
                    </div>

                    <!-- Chatbot Section -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div id="chatResponse" class="mb-3" style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;"></div>
                            <div class="input-group">
                                <input type="text" id="chatInput" class="form-control" placeholder="Posez une question sur les espaces verts...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="sendChat">Envoyer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            @include('admin_dashboard.partials.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatInput = document.getElementById('chatInput');
            const sendChat = document.getElementById('sendChat');
            const chatResponse = document.getElementById('chatResponse');

            sendChat.addEventListener('click', function() {
                const message = chatInput.value.trim();
                if (!message) return;

                // Add user message
                chatResponse.innerHTML += `<p><strong>You:</strong> ${message}</p>`;

                // Add loading indicator
                const loadingId = `loading-${Date.now()}`;
                chatResponse.innerHTML += `<p id="${loadingId}"><strong>Bot:</strong> ...</p>`;
                chatResponse.scrollTop = chatResponse.scrollHeight;

                fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Added CSRF token
                    },
                    body: JSON.stringify({ message: message, sessionId: 'default_session' })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Replace loading indicator with bot response
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.outerHTML = `<p><strong>Bot:</strong> ${data.reply || 'Erreur lors de la réponse.'}</p>`;
                        chatResponse.scrollTop = chatResponse.scrollHeight;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Replace loading indicator with error message
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.outerHTML = `<p><strong>Bot:</strong> Désolé, une erreur s'est produite. Veuillez réessayer.</p>`;
                        chatResponse.scrollTop = chatResponse.scrollHeight;
                    }
                });

                chatInput.value = '';
            });

            // Allow Enter key to send message
            chatInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendChat.click();
                }
            });
        });
    </script>
    @vite([
        'resources/vendor/jquery/jquery.min.js',
        'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/vendor/jquery-easing/jquery.easing.min.js',
        'resources/js/sb-admin-2.min.js',
        'resources/vendor/chart.js/Chart.min.js',
        'resources/js/demo/chart-area-demo.js',
        'resources/js/demo/chart-pie-demo.js'
    ])
</body>
</html>