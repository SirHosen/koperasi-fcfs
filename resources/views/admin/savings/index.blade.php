@extends('layouts.app')

@section('title', 'Data Simpanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Simpanan</h1>
    <a href="{{ route('admin.savings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Transaksi
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.savings.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama anggota atau kode transaksi..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Saldo</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($savings as $saving)
                        <tr>
                            <td>{{ $saving->transaction_code }}</td>
                            <td>{{ $saving->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $saving->member->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $saving->type == 'deposit' ? 'success' : 'danger' }}">
                                    {{ $saving->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                            <td>{{ $saving->created_by }}</td>
                            <td>
                                <a href="{{ route('admin.savings.show', $saving) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.savings.edit', $saving) }}"
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.savings.destroy', $saving) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data simpanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $savings->links() }}
    </div>
</div>
@endsection
