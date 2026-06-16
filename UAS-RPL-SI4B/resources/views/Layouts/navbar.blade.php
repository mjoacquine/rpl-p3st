<li class="nav-item dropdown list-unstyled me-3 position-relative">
    <a class="nav-link dropdown-toggle no-caret" href="#" id="navbarDropdownNotif" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-bell text-warning fa-lg"></i>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.5em;">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="navbarDropdownNotif" style="width: 320px; max-height: 400px; overflow-y: auto;">
        <li class="dropdown-header fw-bold text-dark border-bottom pb-2 mb-2">
            <i class="fa-solid fa-bell me-2 text-primary"></i> Pemberitahuan Terbaru
        </li>
        
        @forelse(auth()->user()->unreadNotifications as $notification)
            <li>
                <a class="dropdown-item py-2 border-bottom text-wrap" href="#">
                    <div class="d-flex align-items-start">
                        <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-2">
                            <i class="fa-solid fa-truck-pickup small"></i>
                        </div>
                        <div class="flex-fill">
                            <p class="mb-0 small fw-semibold text-dark" style="line-height: 1.3;">
                                {{ $notification->data['pesan'] ?? 'Ada pemberitahuan baru.' }}
                            </p>
                            <span class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                                <i class="fa-regular fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="py-4 text-center text-muted">
                <div class="mb-2 opacity-50">
                    <i class="fa-solid fa-bell-slash fa-2x"></i>
                </div>
                <p class="small mb-0">Belum ada notifikasi masuk</p>
            </li>
        @endforelse
    </ul>
</li>