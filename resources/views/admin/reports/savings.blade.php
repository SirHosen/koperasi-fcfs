@extends('layouts.app')

@section('title', 'Laporan Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Simpanan</h1>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.savings') }}" class="row g-3">
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
                <label for="type" class="form-label">Jenis Transaksi</label>
                <select class="form-select" id="type" name="type">
                    <option value="">Semua</option>
                    <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Setoran</option>
                    <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Penarikan</option>
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
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="text-uppercase">Total Setoran</h6>
                <h3 class="mb-0">Rp {{ number_format($totalDeposit, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h6 class="text-uppercase">Total Penarikan</h6>
                <h3 class="mb-0">Rp {{ number_format($totalWithdrawal, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="text-uppercase">Selisih</h6>
                <h3 class="mb-0">Rp {{ number_format($totalDeposit - $totalWithdrawal, 0, ',', '.') }}</h3>
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
                        <th>Kode Transaksi</th>
                        <th>Anggota</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($savings as $saving)
                        <tr>
                            <td>{{ $saving->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $saving->transaction_code }}</td>
                            <td>{{ $saving->member->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $saving->type == 'deposit' ? 'success' : 'danger' }}">
                                    {{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                            <td>{{ $saving->description ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Total:</td>
                        <td colspan="3">
                            Setoran: Rp {{ number_format($totalDeposit, 0, ',', '.') }}<br>
                            Penarikan: Rp {{ number_format($totalWithdrawal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
