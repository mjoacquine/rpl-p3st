<div class="dropdown">
    <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
        🔔 
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>
    
    <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0 rounded-3" style="width: 340px;">
        @if(auth()->user()->unreadNotifications->isEmpty())
            <p class="text-muted text-center my-2 small">Tidak ada notifikasi baru</p>
        @else
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <h6 class="fw-bold mb-0 text-dark">Pemberitahuan Baru</h6>
                
                <form action="{{ route('notification.delete_all') }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi baru?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 small fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-trash-can me-1"></i>Hapus Semua
                    </button>
                </form>
            </div>
            
            <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                @foreach(auth()->user()->unreadNotifications as $notification)
                    
                    <div class="notification-item d-flex justify-content-between align-items-start mb-2 p-2 rounded bg-light hover-shadow border">
                        
                        <a href="{{ route('notification.read', $notification->id) }}" class="text-decoration-none text-dark flex-grow-1 pe-2">
                            <h6 class="fw-bold mb-1 text-success small" style="font-size: 13px;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $notification->data['title'] ?? 'Pemberitahuan' }}
                            </h6>
                            <p class="text-secondary mb-2" style="font-size: 11px; line-height: 1.4;">
                                {{ $notification->data['message'] ?? 'Ada pembaruan terkait jadwal Anda.' }}
                            </p>
                            
                            <div class="d-flex justify-content-between pt-1 border-top border-opacity-10 text-muted" style="font-size: 10px;">
                                <span>
                                    <i class="fa-solid fa-clock me-1 text-primary"></i> 
                                    Jam: {{ isset($notification->data['pickup_time']) ? \Carbon\Carbon::parse($notification->data['pickup_time'])->format('H:i') : '-' }} WIB
                                </span>
                                <span>
                                    <i class="fa-solid fa-weight-scale me-1 text-warning"></i> 
                                    Beban: {{ $notification->data['weight'] ?? '0' }} Kg
                                </span>
                            </div>
                        </a>

                        <form action="{{ route('notification.delete', $notification->id) }}" method="POST" class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 py-1 px-2 mt-1 rounded" title="Hapus Notifikasi">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>