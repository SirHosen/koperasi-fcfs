@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Anggota</h1>
    <div>
        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">No. Anggota</td>
                        <td>: {{ $member->member_number }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $member->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $member->user->email }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $member->user->phone }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $member->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{ $member->birth_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $member->user->address }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Keanggotaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">Pekerjaan</td>
                        <td>: {{ $member->occupation }}</td>
                    </tr>
                    <tr>
                        <td>Penghasilan/bulan</td>
                        <td>: Rp {{ number_format($member->monthly_income, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Bergabung</td>
                        <td>: {{ $member->join_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:
                            <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                                {{ $member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Saldo Simpanan</td>
                        <td>: Rp {{ number_format($member->getCurrentBalance(), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Total Pinjaman Aktif</td>
                        <td>: Rp {{ number_format($member->loans()->where('status', 'approved')->sum('remaining_payment'), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Simpanan Terakhir</h5>
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
                            @forelse($member->savings()->latest('transaction_date')->take(5)->get() as $saving)
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
                                    <td colspan="4" class="text-center">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Pinjaman</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($member->loans()->latest('request_date')->take(5)->get() as $loan)
                                <tr>
                                    <td>{{ $loan->request_date->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                    <td>
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
                                    <td>
                                        @if($loan->status == 'approved' || $loan->status == 'paid')
                                            Rp {{ number_format($loan->remaining_payment, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada pinjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
