<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Indonesia Emergency Responder</title>
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('layout/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{asset('layout/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('layout/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('layout/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('layout/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('layout/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('layout/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('layout/plugins/summernote/summernote-bs4.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('layout/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('layout/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('layout/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('layout/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('layout/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        @include('template.sidebar')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@if(request()->is('/') || request()->is('index')) Dashboard @else
                                @yield('title') @endif</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    
                    <div class="row">
                        <div class="col-12">
                            <button id="enableNotif" class="btn btn-success">
  Aktifkan Notifsikasi
</button>

                            @if(auth()->check() && auth()->user()->level === 'basic')
                                @forelse($tiket as $a)
                                <div class="card @if($a->status=='selesai')card-success @else card-danger @endif">
                                    <div class="card-header">
                                        <h3 class="card-title">Laporan Kejadian IER</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: block;">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-hover text-nowrap">
                                                        <tr>
                                                            <th>Jenis Kejadian</th>
                                                            <td>{{ $a->kejadian }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Waktu Kejadian</th>
                                                            <td>{{ $a->terima_berita }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tanggal Kejadian</th>
                                                            <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Responder</th>
                                                            <td>{!! nl2br($a->responder) !!} </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                @empty
                                <div class="card card-primary">
                                    <div class="card-body" style="display: block;">
                                        Tidak Ada Laporan
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                @endforelse 
                            @endif
                        </div>

                        @if(request()->is('/') || request()->is('index'))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $jmlhanggota }}</h3>
                                    <p>Jumlah Anggota</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-stalker"></i>
                                </div>
                                <a href="{{ route('agt.index2') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        @else
                        @yield('content')
                        @endif
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="#">Indonesia Emergency Responder</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{asset('layout/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('layout/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('layout/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('layout/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('layout/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('layout/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('layout/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('layout/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('layout/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('layout/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('layout/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('layout/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('layout/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('layout/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('layout/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('layout/dist/js/demo.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('layout/plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{asset('layout/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('layout/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('layout/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('sweetalert'))
        <script>
            Swal.fire({
                title: "{{ session('sweetalert.title') }}",
                text: "{{ session('sweetalert.text') }}",
                icon: "{{ session('sweetalert.icon') }}",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Akun ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + userId).submit();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#dateInput').datepicker();
            $('.select2').select2({
                theme: "bootstrap4" // Optional theme, use "default" or customize as needed
            });
        });

    </script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

    </script>
    <script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-app.js";
import { getMessaging, getToken, onMessage } 
from "https://www.gstatic.com/firebasejs/12.7.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyDHeVWGv57jQCs5ixwtKlXjOu-bgM9yOYY",
    authDomain: "ier-notif.firebaseapp.com",
    projectId: "ier-notif",
    storageBucket: "ier-notif.firebasestorage.app",
    messagingSenderId: "876665599326",
    appId: "1:876665599326:web:5a1be26bdd56bd42350bcf"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Register service worker
const registration = await navigator.serviceWorker.register(
    '/firebase-messaging-sw.js'
);

console.log('SW REGISTERED:', registration);

// Request permission
const permission = await Notification.requestPermission();
if (permission === 'granted') {

    const token = await getToken(messaging, {
        vapidKey: 'BBlPfuteR8wFlVbzQNQ7FFN6XT_MKw2Hmqs9vHOPgXN0WIOVBugpRdxwD8G0x5_BgWSjEOsizucxvQUqUpQisL0',
        serviceWorkerRegistration: registration
    });

    if (token) {
        fetch('/save-fcm-token', {
            method: 'POST',
            credentials: 'same-origin', // 🔥 INI KUNCI UTAMA
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ token })
        });
    }
}

// Notif saat browser aktif
onMessage(messaging, (payload) => {
    new Notification(payload.notification.title, {
        body: payload.notification.body
    });
});
</script>

</body>

</html>
