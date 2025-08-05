@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Notifikasi</h1>
    @if($notifications->where('is_read', false)->count() > 0)
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
        </form>
    @endif
</div>

<div class="card">
    <div class="card-body">
        @forelse($notifications as $notification)
            <div class="d-flex align-items-start mb-3 p-3 border rounded {{ !$notification->is_read ? 'bg-light' : '' }}">
                <div class="flex-shrink-0">
                    @if($notification->type == 'success')
                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                    @elseif($notification->type == 'danger')
                        <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                    @elseif($notification->type == 'warning')
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>
                    @else
                        <i class="bi bi-info-circle-fill text-info fs-4"></i>
                    @endif
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">{{ $notification->title }}</h6>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $notification->message }}</p>
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.read', $notification) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-link p-0">
                                <small>Tandai dibaca</small>
                            </button>
                        </form>
                    @else
                        <small class="text-muted">Dibaca pada {{ $notification->read_at->format('d/m/Y H:i') }}</small>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-bell-slash fs-1 text-muted"></i>
                <p class="text-muted mt-2">Tidak ada notifikasi</p>
            </div>
        @endforelse

        {{ $notifications->links() }}
    </div>
</div>
@endsection
