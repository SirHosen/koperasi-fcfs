@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Ajukan Pinjaman</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('member.loans.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah Pinjaman</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                   id="amount" name="amount" value="{{ old('amount') }}"
                                   min="500000" max="50000000" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Minimal Rp 500.000 - Maksimal Rp 50.000.000</small>
                    </div>

                    <div class="mb-3">
                        <label for="duration_months" class="form-label">Jangka Waktu (Bulan)</label>
                        <select class="form-select @error('duration_months') is-invalid @enderror"
                                id="duration_months" name="duration_months" required>
                            <option value="">Pilih jangka waktu...</option>
                            @for($i = 3; $i <= 60; $i += 3)
                                <option value="{{ $i }}" {{ old('duration_months') == $i ? 'selected' : '' }}>
                                    {{ $i }} Bulan
                                </option>
                            @endfor
                        </select>
                        @error('duration_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Tujuan Pinjaman</label>
                        <textarea class="form-control @error('purpose') is-invalid @enderror"
                                  id="purpose" name="purpose" rows="3" required>{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info" id="loanCalculation" style="display: none;">
                        <h6>Simulasi Pinjaman:</h6>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Jumlah Pinjaman</td>
                                <td>: Rp <span id="calcAmount">0</span></td>
                            </tr>
                            <tr>
                                <td>Bunga (1.5% per bulan)</td>
                                <td>: Rp <span id="calcInterest">0</span></td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td>: Rp <span id="calcTotal">0</span></td>
                            </tr>
                            <tr>
                                <td>Angsuran per Bulan</td>
                                <td>: <strong>Rp <span id="calcMonthly">0</span></strong></td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Ajukan Pinjaman
                        </button>
                        <a href="{{ route('member.loans.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Penting</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Bunga pinjaman: <strong>1.5% per bulan</strong></li>
                    <li>Minimal pinjaman: <strong>Rp 500.000</strong></li>
                    <li>Maksimal pinjaman: <strong>Rp 50.000.000</strong></li>
                    <li>Jangka waktu: <strong>3-60 bulan</strong></li>
                    <li>Pengajuan diproses dengan sistem <strong>FCFS</strong> (First Come First Served)</li>
                    <li>Proses persetujuan maksimal <strong>3 hari kerja</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const durationSelect = document.getElementById('duration_months');
    const loanCalculation = document.getElementById('loanCalculation');

    function calculateLoan() {
        const amount = parseFloat(amountInput.value) || 0;
        const duration = parseInt(durationSelect.value) || 0;

        if (amount > 0 && duration > 0) {
            const interestRate = 1.5; // 1.5% per month
            const totalInterest = (amount * interestRate * duration) / 100;
            const totalPayment = amount + totalInterest;
            const monthlyPayment = totalPayment / duration;

            document.getElementById('calcAmount').textContent = amount.toLocaleString('id-ID');
            document.getElementById('calcInterest').textContent = totalInterest.toLocaleString('id-ID');
            document.getElementById('calcTotal').textContent = totalPayment.toLocaleString('id-ID');
            document.getElementById('calcMonthly').textContent = Math.ceil(monthlyPayment).toLocaleString('id-ID');

            loanCalculation.style.display = 'block';
        } else {
            loanCalculation.style.display = 'none';
        }
    }

    amountInput.addEventListener('input', calculateLoan);
    durationSelect.addEventListener('change', calculateLoan);
});
</script>
@endpush
@endsection
