@extends('layouts.app')

@section('title', 'Dashboard Member')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Member</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Anggota</h5>
                <table class="table table-sm">
                    <tr>
                        <td>No. Anggota</td>
                        <td>: {{ $member->member_number }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $member->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Bergabung</td>
                        <td>: {{ $member->join_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                            {{ $member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Saldo Simpanan</h6>
                        <h3 class="mb-0">Rp {{ number_format($currentBalance, 0, ',', '.') }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-piggy-bank fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Pinjaman</h6>
                        <h3 class="mb-0">Rp {{ number_format($totalLoanAmount, 0, ',', '.') }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-cash-coin fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Simpanan Terakhir</h5>
                <a href="{{ route('member.savings.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSavings as $saving)
                                <tr>
                                    <td>{{ $saving->transaction_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $saving->type == 'deposit' ? 'success' : 'danger' }}">
                                            {{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada transaksi simpanan</td>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pinjaman Aktif</h5>
                <a href="{{ route('member.loans.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Pinjaman</th>
                                <th>Jumlah</th>
                                <th>Sisa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeLoans as $loan)
                                <tr>
                                    <td>{{ $loan->loan_number }}</td>
                                    <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $loan->status == 'approved' ? 'success' : 'warning' }}">
                                            {{ $loan->status == 'approved' ? 'Aktif' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada pinjaman aktif</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if($notifications->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Notifikasi Terbaru</h5>
                <a href="{{ route('notifications') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @foreach($notifications as $notification)
                    <div class="alert alert-{{ $notification->type }} alert-dismissible fade show" role="alert">
                        <strong>{{ $notification->title }}</strong><br>
                        {{ $notification->message }}
                        <small class="d-block mt-1 text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection
