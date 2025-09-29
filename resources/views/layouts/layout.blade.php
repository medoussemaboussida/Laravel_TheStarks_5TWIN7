<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Custom fonts for this template -->
    <link href="{{ Vite::asset('resources/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    @vite(['resources/assets/css/sb-admin-2.min.css'])

    <!-- DataTables CSS -->
    <link href="{{ Vite::asset('resources/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('partials.aside')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('partials.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('partials.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    @include('partials.logout-modal')

    <!-- JS Scripts -->
    @vite([
        'resources/assets/vendor/jquery/jquery.min.js',
        'resources/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/assets/vendor/jquery-easing/jquery.easing.min.js',
        'resources/assets/js/sb-admin-2.min.js',
        'resources/assets/vendor/chart.js/Chart.min.js',
        'resources/assets/js/demo/chart-area-demo.js',
        'resources/assets/js/demo/chart-pie-demo.js'
    ])

    <!-- DataTables JS -->
    <script src="{{ Vite::asset('resources/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Demo Script -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
