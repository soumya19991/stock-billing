<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard</title>

    <!-- CSS files -->
    <link href="{{ asset('assets/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/demo.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Desktop sidebar */
        #desktopSidebar {
            width: 260px;
            background-color: #182433; /* dark */
            color: white;
        }

        #desktopSidebar a.nav-link {
            color: white;
        }

        #desktopSidebar a.nav-link:hover,
        #desktopSidebar a.nav-link.active {
            background-color: #2a2a2a;
            color: #fff;
        }

        /* Mobile sidebar */
        #mobileSidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px;
            height: 100%;
            background-color: #182433;
            color: white;
            z-index: 1050;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        #mobileSidebar a.nav-link {
            color: white;
        }

        #mobileSidebar a.nav-link:hover,
        #mobileSidebar a.nav-link.active {
            background-color: #2a2a2a;
            color: #fff;
        }

        #mobileSidebar.active {
            left: 0;
        }

        #mobileSidebar .close-btn {
            text-align: right;
            padding: 10px;
        }

        /* Hide desktop sidebar on mobile */
        @media (max-width: 991px) {
            #desktopSidebar {
                display: none;
            }
        }

        /* Hide mobile toggle button on desktop */
        @media (min-width: 992px) {
            #mobileSidebar {
                display: none;
            }

            #sidebarToggleBtn {
                display: none;
            }
        }

        /* Main content spacing */
        .main-content {
            flex-grow: 1;
            padding: 1rem;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }

        /* Remove margin on mobile */
        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Scrollbar for sidebar */
        #desktopSidebar::-webkit-scrollbar,
        #mobileSidebar::-webkit-scrollbar {
            width: 10px;
        }

        #desktopSidebar::-webkit-scrollbar-track,
        #mobileSidebar::-webkit-scrollbar-track {
            background: #141414;
        }

        #desktopSidebar::-webkit-scrollbar-thumb,
        #mobileSidebar::-webkit-scrollbar-thumb {
            background-color: #333;
            border-radius: 10px;
            border: 2px solid #141414;
        }
    </style>

    @stack('css')
</head>

<body class="d-flex">
    <!-- Desktop Sidebar -->
    <aside id="desktopSidebar" class="navbar navbar-vertical navbar-expand-lg navbar-dark vh-100">
        @include('layout.admin.partials.sidebar')
    </aside>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar">
        <div class="close-btn">
            <button class="btn btn-light btn-sm" id="closeSidebar">&times;</button>
        </div>
        @include('layout.admin.partials.sidebar')
    </div>

    <!-- Main Content -->
    <div class="d-flex flex-column w-100">
        <!-- Header -->
        @include('layout.admin.partials.header')

        <!-- Page Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layout.admin.partials.footer')
    </div>

    <!-- Scripts -->
    <script>
        const mobileSidebar = document.getElementById('mobileSidebar');
        const openBtn = document.getElementById('sidebarToggleBtn');
        const closeBtn = document.getElementById('closeSidebar');

        openBtn?.addEventListener('click', () => {
            mobileSidebar.classList.add('active');
        });

        closeBtn?.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
        });

        window.addEventListener('click', function(e) {
            if (!mobileSidebar.contains(e.target) && !openBtn.contains(e.target)) {
                mobileSidebar.classList.remove('active');
            }
        });
    </script>

    @stack('js')
</body>
</html>
