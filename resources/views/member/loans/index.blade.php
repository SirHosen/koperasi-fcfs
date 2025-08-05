@extends('layouts.app')

@section('title', 'Riwayat Pinjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Pinjaman</h1>
    @if(!Auth::user()->member->loans()->whereIn('status', ['pending', 'approved'])->where('remaining_payment', '>', 0)->exists())
        <a href="{{ route('member.loans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajukan Pinjaman
        </a>
    @endif
</div>

@if(Auth::user()->member->loans()->whereIn('status', ['pending', 'approved'])->where('remaining_payment', '>', 0)->exists())
<div class="alert alert-info">
    <i class="bi bi-info-circle"></i>
    Anda masih memiliki pinjaman aktif. Lunasi terlebih dahulu sebelum mengajukan pinjaman baru.
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Pinjaman</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Jumlah</th>
                        <th>Jangka Waktu</th>
                        <th>Status</th>
                        <th>Sisa Pinjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->loan_number }}</td>
                            <td>{{ $loan->request_date->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->duration_months }} bulan</td>
                            <td>
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
                            <td>
                                @if($loan->status == 'approved' || $loan->status == 'paid')
                                    Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('member.loans.show', $loan) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat pinjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $loans->links() }}
    </div>
</div>
@endsection
