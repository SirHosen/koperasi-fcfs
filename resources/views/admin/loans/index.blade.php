@extends('layouts.app')

@section('title', 'Data Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Pinjaman</h1>
    <a href="{{ route('admin.loans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Pinjaman
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.loans.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama anggota atau nomor pinjaman..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

@if($loans->where('status', 'pending')->count() > 0)
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i>
    Ada {{ $loans->where('status', 'pending')->count() }} pinjaman menunggu persetujuan (FCFS).
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Pinjaman</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Anggota</th>
                        <th>Jumlah</th>
                        <th>Jangka Waktu</th>
                        <th>Status</th>
                        <th>Sisa Pinjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->loan_number }}</td>
                            <td>
                                {{ $loan->request_date->format('d/m/Y') }}
                                <small class="text-muted d-block">{{ $loan->request_date->format('H:i') }}</small>
                            </td>
                            <td>{{ $loan->member->user->name }}</td>
                            <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->duration_months }} bulan</td>
                            <td>
                                @if($loan->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($loan->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($loan->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-info">Lunas</span>
                                @endif
                            </td>
                            <td>
                                @if($loan->status == 'approved' || $loan->status == 'paid')
                                    Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.loans.show', $loan) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($loan->status == 'pending')
                                    <button type="button" class="btn btn-sm btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveModal{{ $loan->id }}"
                                            title="Setujui">
                                        <i class="bi bi-check-circle"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $loan->id }}"
                                            title="Tolak">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Approve Modal -->
                        @if($loan->status == 'pending')
                        <div class="modal fade" id="approveModal{{ $loan->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Setujui Pinjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menyetujui pinjaman ini?</p>
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Anggota</td>
                                                <td>: {{ $loan->member->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>: Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Bayar</td>
                                                <td>: Rp {{ number_format($loan->total_payment, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Angsuran/bulan</td>
                                                <td>: Rp {{ number_format($loan->monthly_payment, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Setujui</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $loan->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tolak Pinjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Berikan alasan penolakan:</p>
                                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pinjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $loans->links() }}
    </div>
</div>
@endsection
