@extends('layouts.app')

@section('title', 'Laporan Pinjaman Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Pinjaman Saya</h1>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('member.reports.loans') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                       value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                       value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>No. Pinjaman</th>
                        <th>Jumlah</th>
                        <th>Jangka Waktu</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Sisa</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->request_date->format('d/m/Y') }}</td>
                            <td>{{ $loan->loan_number }}</td>
                            <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->duration_months }} bulan</td>
                            <td>Rp {{ number_format($loan->total_payment, 0, ',', '.') }}</td>
                            <td>
                                @if($loan->status == 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
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
                            <td>{{ $loan->purpose }}</td>
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
