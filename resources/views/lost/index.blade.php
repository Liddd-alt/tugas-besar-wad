@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Barang Hilang</h5>
                    <a href="{{ route('lost.create') }}" class="btn btn-primary">Tambah Baru</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Pelapor</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($losts as $lost)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lost->name }}</td>
                                        <td>{{ $lost->category->name }}</td>
                                        <td>{{ $lost->location }}</td>
                                        <td>{{ $lost->user->name }}</td>
                                        <td>
                                            @if($lost->image)
                                                <img src="{{ asset('storage/image/' . $lost->image) }}" alt="{{ $lost->name }}" class="img-thumbnail" style="max-width: 100px;">
                                            @else
                                                <span class="text-muted">Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($lost->status) && $lost->status === 'matched')
                                                <span class="badge bg-success text-white">Sudah Ditemukan</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Belum Ditemukan</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('lost.show', $lost->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('lost.edit', $lost->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('lost.destroy', $lost->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
