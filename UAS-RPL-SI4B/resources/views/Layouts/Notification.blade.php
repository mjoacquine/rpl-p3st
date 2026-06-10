<div class="dropdown">
    <button class="btn btn-light position-relative">
        🔔 
        <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
    </button>
    
    <div class="dropdown-menu p-3">
        @if(auth()->user()->unreadNotifications->isEmpty())
            <p class="text-muted text-center">Tidak ada notifikasi baru</p>
        @else
            @foreach(auth()->user()->unreadNotifications as $notification)
                <div class="notification-item border-bottom py-2">
                    <h6 class="fw-bold mb-1">{{ $notification->data['title'] }}</h6>
                    <p class="small text-muted mb-0">{{ $notification->data['message'] }}</p>
                </div>
            @endforeach
        @endif
    </div>
</div>