@extends('layouts.app')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pinjaman</h1>
    <a href="{{ route('member.loans.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pinjaman</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">No. Pinjaman</td>
                        <td>: {{ $loan->loan_number }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:
                            @if($loan->status == 'pending')
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif($loan->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($loan->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-info">Lunas</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>: {{ $loan->request_date->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($loan->approval_date)
                    <tr>
                        <td>Tanggal Persetujuan</td>
                        <td>: {{ $loan->approval_date->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    @if($loan->rejection_reason)
                    <tr>
                        <td>Alasan Penolakan</td>
                        <td>: {{ $loan->rejection_reason }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Tujuan Pinjaman</td>
                        <td>: {{ $loan->purpose }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Detail Keuangan</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">Jumlah Pinjaman</td>
                        <td>: Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Jangka Waktu</td>
                        <td>: {{ $loan->duration_months }} bulan</td>
                    </tr>
                    <tr>
                        <td>Bunga per Bulan</td>
                        <td>: {{ $loan->interest_rate }}%</td>
                    </tr>
                    <tr>
                        <td>Angsuran per Bulan</td>
                        <td>: Rp {{ number_format($loan->monthly_payment, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Total Pembayaran</td>
                        <td>: Rp {{ number_format($loan->total_payment, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Sisa Pinjaman</td>
                        <td>: <strong>Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($loan->status == 'approved')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Jadwal Pembayaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Angsuran Ke</th>
                        <th>Jatuh Tempo</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->payments as $payment)
                        <tr>
                            <td>{{ $payment->installment_number }}</td>
                            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($payment->status == 'paid')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($payment->payment_date < now())
                                    <span class="badge bg-danger">Jatuh Tempo</span>
                                @else
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                {{ $payment->status == 'paid' ? $payment->updated_at->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                @if($payment->penalty > 0)
                                    Rp {{ number_format($payment->penalty, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
