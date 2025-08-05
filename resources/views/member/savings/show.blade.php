@extends('layouts.app')

@section('title', 'Detail Transaksi Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Transaksi Simpanan</h1>
    <a href="{{ route('member.savings.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">Kode Transaksi</td>
                        <td>: {{ $saving->transaction_code }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Transaksi</td>
                        <td>: {{ $saving->transaction_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Transaksi</td>
                        <td>:
                            <span class="badge bg-{{ $saving->type == 'deposit' ? 'success' : 'danger' }}">
                                {{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: <strong>Rp {{ number_format($saving->amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Saldo Setelah Transaksi</td>
                        <td>: <strong>Rp {{ number_format($saving->balance, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>: {{ $saving->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Diproses Oleh</td>
                        <td>: {{ $saving->created_by }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
