@extends('layouts.app')

@section('title', 'Edit Transaksi Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Transaksi Simpanan</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>Perhatian:</strong> Hanya tanggal transaksi dan keterangan yang dapat diubah.
        </div>

        <form method="POST" action="{{ route('admin.savings.update', $saving) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Transaksi</label>
                    <input type="text" class="form-control" value="{{ $saving->transaction_code }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Anggota</label>
                    <input type="text" class="form-control"
                           value="{{ $saving->member->member_number }} - {{ $saving->member->user->name }}" disabled>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <input type="text" class="form-control"
                           value="{{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="text" class="form-control"
                           value="Rp {{ number_format($saving->amount, 0, ',', '.') }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Saldo</label>
                    <input type="text" class="form-control"
                           value="Rp {{ number_format($saving->balance, 0, ',', '.') }}" disabled>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                    <input type="date" class="form-control @error('transaction_date') is-invalid @enderror"
                           id="transaction_date" name="transaction_date"
                           value="{{ old('transaction_date', $saving->transaction_date->format('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Keterangan</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3">{{ old('description', $saving->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.savings.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
