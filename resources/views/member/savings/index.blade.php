@extends('layouts.app')

@section('title', 'Riwayat Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Simpanan</h1>
    <h3 class="text-primary">Saldo: Rp {{ number_format(Auth::user()->member->getCurrentBalance(), 0, ',', '.') }}</h3>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($savings as $saving)
                        <tr>
                            <td>{{ $saving->transaction_code }}</td>
                            <td>{{ $saving->transaction_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $saving->type == 'deposit' ? 'success' : 'danger' }}">
                                    {{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                            <td>{{ $saving->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('member.savings.show', $saving) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi simpanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $savings->links() }}
    </div>
</div>
@endsection
