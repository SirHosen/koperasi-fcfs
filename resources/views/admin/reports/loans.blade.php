@extends('layouts.app')

@section('title', 'Laporan Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Pinjaman</h1>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.loans') }}" class="row g-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                       value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                       value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-1">Total Pinjaman</h6>
                <h4 class="mb-0">{{ $summary['total_loans'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-1">Total Nilai</h6>
                <h5 class="mb-0">Rp {{ number_format($summary['total_amount'], 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6 class="mb-1">Disetujui</h6>
                <h4 class="mb-0">{{ $summary['approved'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h6 class="mb-1">Pending</h6>
                <h4 class="mb-0">{{ $summary['pending'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h6 class="mb-1">Ditolak</h6>
                <h4 class="mb-0">{{ $summary['rejected'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h6 class="mb-1">Lunas</h6>
                <h4 class="mb-0">{{ $summary['paid'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Pinjaman</th>
                        <th>Anggota</th>
                        <th>Jumlah</th>
                        <th>Jangka Waktu</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->request_date->format('d/m/Y') }}</td>
                            <td>{{ $loan->loan_number }}</td>
                            <td>{{ $loan->member->user->name }}</td>
                            <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->duration_months }} bulan</td>
                            <td>Rp {{ number_format($loan->total_payment, 0, ',', '.') }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
