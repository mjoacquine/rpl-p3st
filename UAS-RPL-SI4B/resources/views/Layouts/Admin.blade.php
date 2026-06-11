@extends('Layouts.App')

@section('global-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-0 shadow-sm" style="min-height: 100vh;">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-block">
                <div class="p-3 bg-p3st text-white fw-bold text-center border-bottom border-light border-opacity-10">
                    <i class="fa-solid fa-user-gear me-2"></i>P3ST ADMIN PANEL
                </div>
            </a>

            <div class="list-group list-group-flush p-2">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded my-1">
                    <i class="fa-solid fa-chart-line me-2"></i>Ringkasan
                </a>
                <a href="{{ route('admin.catalog.index') }}" class="list-group-item list-group-item-action border-0 rounded my-1">
                    <i class="fa-solid fa-sliders me-2"></i>Kelola Harga
                </a>
                <a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action border-0 rounded my-1">
                    <i class="fa-solid fa-users me-2"></i>Manajemen User
                </a>
                <a href="{{ route('admin.report.index') }}" class="list-group-item list-group-item-action border-0 rounded my-1">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>Laporan Bulanan
                </a>
                
                <div class="mt-4 px-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-danger w-100" type="submit">
                            <i class="fa-solid fa-power-off me-1"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            
            <div class="d-flex justify-content-end align-items-center mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3 fw-bold">Halo, {{ Auth::user()->name }}</span>
                    @include('Layouts.Notification')
                </div>
            </div>
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif
            
            @yield('content')
            
        </div>
    </div>
</div>
@endsection