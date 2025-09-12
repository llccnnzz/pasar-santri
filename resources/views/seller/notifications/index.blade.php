@extends('layouts.seller.main')

@section('title', 'Notifications')

@section('content')
    <div class="card border-0 rounded-3 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Notifications</h2>
        </div>
    </div>

    <div class="card border-0 rounded-3">
        <div class="card-body text-body p-25">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i data-feather="check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i data-feather="alert-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div
                class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-2 mb-sm-0">Notifications List</h4>
            </div>

            @forelse($notifications as $notif)
                @php
                    $data = $notif->data;
                @endphp
                <div class="card mb-3 {{ $notif->read_at ? 'bg-light' : '' }}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">{{ $data['message'] ?? 'No message' }}</h5>
                            <p class="mb-1">
                                <small class="text-muted">Status: {{ $data['formatted_type'] ?? 'N/A' }}</small>
                            </p>
                            <p class="mb-1">
                                <small class="text-muted">
                                    User: {{ $data['data']['user']['name'] ?? 'Unknown' }}
                                    ({{ $data['data']['user']['email'] ?? '-' }})
                                </small>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                        <div>
                            @if (!$notif->read_at)
                                <form action="{{ route('seller.notifications.markAsRead', $notif->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm border-0 rounded-circle text-center text-success bg-success-subtle mark-read-btn"
                                        data-bs-toggle="tooltip" title="Mark as read">
                                        <i data-feather="check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No notifications found.</p>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
