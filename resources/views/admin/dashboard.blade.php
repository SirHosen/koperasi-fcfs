@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Anggota</h6>
                        <h2 class="mb-0">{{ $totalMembers }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Simpanan</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-piggy-bank fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Pinjaman</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalLoans, 0, ',', '.') }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-cash-coin fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Pinjaman Pending</h6>
                        <h2 class="mb-0">{{ $pendingLoans }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-clock-history fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaksi Simpanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Anggota</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->member->user->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type == 'deposit' ? 'success' : 'danger' }}">
                                            {{ $transaction->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengajuan Pinjaman Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Anggota</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLoans as $loan)
                                <tr>
                                    <td>{{ $loan->request_date->format('d/m/Y') }}</td>
                                    <td>{{ $loan->member->user->name }}</td>
                                    <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada pinjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
