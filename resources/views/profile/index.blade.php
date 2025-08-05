@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Profil Saya</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Akun</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h6>Ubah Password (Opsional)</h6>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($user->member)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Keanggotaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>No. Anggota</td>
                        <td>: {{ $user->member->member_number }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $user->member->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{ $user->member->birth_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ $user->member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>: {{ $user->member->occupation }}</td>
                    </tr>
                    <tr>
                        <td>Bergabung Sejak</td>
                        <td>: {{ $user->member->join_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:
                            <span class="badge bg-{{ $user->member->status == 'active' ? 'success' : 'danger' }}">
                                {{ $user->member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
