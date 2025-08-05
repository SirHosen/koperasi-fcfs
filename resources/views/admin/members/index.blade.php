@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Anggota</h1>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Anggota
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.members.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama, email, no anggota, atau NIK..."
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
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>{{ $member->member_number }}</td>
                            <td>{{ $member->user->name }}</td>
                            <td>{{ $member->user->email }}</td>
                            <td>{{ $member->user->phone }}</td>
                            <td>{{ $member->join_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.members.show', $member) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.members.edit', $member) }}"
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
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
                            <td colspan="7" class="text-center">Tidak ada data anggota</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $members->links() }}
    </div>
</div>
@endsection
