@extends('layouts.app')

@section('title', 'Tambah Transaksi Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Transaksi Simpanan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.savings.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="member_id" class="form-label">Anggota</label>
                    <select class="form-select @error('member_id') is-invalid @enderror"
                            id="member_id" name="member_id" required>
                        <option value="">Pilih Anggota...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}
                                    data-balance="{{ $member->getCurrentBalance() }}">
                                {{ $member->member_number }} - {{ $member->user->name }}
                                (Saldo: Rp {{ number_format($member->getCurrentBalance(), 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Jenis Transaksi</label>
                    <select class="form-select @error('type') is-invalid @enderror"
                            id="type" name="type" required>
                        <option value="">Pilih Jenis...</option>
                        <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Setoran</option>
                        <option value="withdrawal" {{ old('type') == 'withdrawal' ? 'selected' : '' }}>Penarikan</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                               id="amount" name="amount" value="{{ old('amount') }}"
                               min="10000" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal Rp 10.000</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                    <input type="date" class="form-control @error('transaction_date') is-invalid @enderror"
                           id="transaction_date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Keterangan</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info d-none" id="balanceInfo">
                <i class="bi bi-info-circle"></i>
                <span id="balanceMessage"></span>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('admin.savings.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const memberSelect = document.getElementById('member_id');
    const typeSelect = document.getElementById('type');
    const amountInput = document.getElementById('amount');
    const balanceInfo = document.getElementById('balanceInfo');
    const balanceMessage = document.getElementById('balanceMessage');

    function checkBalance() {
        const selectedOption = memberSelect.options[memberSelect.selectedIndex];
        const currentBalance = parseFloat(selectedOption.getAttribute('data-balance')) || 0;
        const amount = parseFloat(amountInput.value) || 0;
        const type = typeSelect.value;

        if (type === 'withdrawal' && memberSelect.value) {
            balanceInfo.classList.remove('d-none');
            if (amount > currentBalance) {
                balanceInfo.classList.remove('alert-info');
                balanceInfo.classList.add('alert-danger');
                balanceMessage.textContent = 'Saldo tidak mencukupi! Saldo saat ini: Rp ' +
                    currentBalance.toLocaleString('id-ID');
            } else {
                balanceInfo.classList.remove('alert-danger');
                balanceInfo.classList.add('alert-info');
                balanceMessage.textContent = 'Saldo setelah penarikan: Rp ' +
                    (currentBalance - amount).toLocaleString('id-ID');
            }
        } else if (type === 'deposit' && memberSelect.value && amount > 0) {
            balanceInfo.classList.remove('d-none', 'alert-danger');
            balanceInfo.classList.add('alert-info');
            balanceMessage.textContent = 'Saldo setelah setoran: Rp ' +
                (currentBalance + amount).toLocaleString('id-ID');
        } else {
            balanceInfo.classList.add('d-none');
        }
    }

    memberSelect.addEventListener('change', checkBalance);
    typeSelect.addEventListener('change', checkBalance);
    amountInput.addEventListener('input', checkBalance);
});
</script>
@endpush
@endsection
