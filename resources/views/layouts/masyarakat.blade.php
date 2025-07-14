<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masyarakat - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: #0d6efd;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 4px;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #0b5ed7;
        }
        .sidebar .sidebar-header {
            font-size: 1.3rem;
            font-weight: bold;
            padding: 24px 20px 12px 20px;
            border-bottom: 1px solid #fff2;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-header">Masyarakat</div>
            <a href="{{ route('masyarakat.dashboard') }}" class="@if(request()->routeIs('masyarakat.dashboard')) active @endif"><i class="fa fa-home me-2"></i> Dashboard</a>
            <a href="{{ route('masyarakat.profile') }}" class="@if(request()->routeIs('masyarakat.profile')) active @endif"><i class="fa fa-user me-2"></i> Profil</a>
            <a href="{{ route('masyarakat.letter-form') }}" class="@if(request()->routeIs('masyarakat.letter-form')) active @endif"><i class="fa fa-envelope-open me-2"></i> Ajukan Surat</a>
            <a href="{{ route('masyarakat.letters.status') }}" class="@if(request()->routeIs('masyarakat.letters.status')) active @endif"><i class="fa fa-list me-2"></i> Status Surat</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button class="btn btn-danger w-100"><i class="fa fa-sign-out-alt me-2"></i>Logout</button>
            </form>
        </nav>
        <main class="col-md-10 ms-sm-auto px-4 py-4">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html> 