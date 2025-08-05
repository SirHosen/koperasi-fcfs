@extends('layouts.app')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pinjaman</h1>
    <a href="{{ route('admin.loans.index') }}" class="btn btn-secondary">
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
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>: {{ $loan->request_date->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($loan->approval_date)
                    <tr>
                        <td>Tanggal Persetujuan</td>
                        <td>: {{ $loan->approval_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Disetujui Oleh</td>
                        <td>: {{ $loan->approved_by }}</td>
                    </tr>
                    @endif
                    @if($loan->rejection_reason)
                    <tr>
                        <td>Alasan Penolakan</td>
                        <td>: {{ $loan->rejection_reason }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card">
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
                        <td>: Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}</td>
                    </tr>
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
                <h5 class="mb-0">Informasi Peminjam</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">No. Anggota</td>
                        <td>: {{ $loan->member->member_number }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $loan->member->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $loan->member->user->email }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $loan->member->user->phone }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>: {{ $loan->member->occupation }}</td>
                    </tr>
                    <tr>
                        <td>Penghasilan/bulan</td>
                        <td>: Rp {{ number_format($loan->member->monthly_income, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($loan->status == 'approved')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Pembayaran</h5>
                @if($loan->remaining_payment > 0)
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    <i class="bi bi-plus"></i> Bayar Angsuran
                </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Angsuran</th>
                                <th>Jatuh Tempo</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loan->payments as $payment)
                                <tr>
                                    <td>Ke-{{ $payment->installment_number }}</td>
                                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ $payment->status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $payment->status == 'paid' ? $payment->updated_at->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada jadwal pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Payment Modal -->
@if($loan->status == 'approved' && $loan->remaining_payment > 0)
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembayaran Angsuran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.loans.payment', $loan) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_id" class="form-label">Pilih Angsuran</label>
                        <select name="payment_id" id="payment_id" class="form-select" required>
                            <option value="">Pilih angsuran...</option>
                            @foreach($loan->payments->where('status', 'pending') as $payment)
                                <option value="{{ $payment->id }}">
                                    Angsuran ke-{{ $payment->installment_number }}
                                    (Rp {{ number_format($payment->amount, 0, ',', '.') }})
                                    - Jatuh tempo: {{ $payment->payment_date->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            Pembayaran akan mengurangi sisa pinjaman sebesar nilai angsuran.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
