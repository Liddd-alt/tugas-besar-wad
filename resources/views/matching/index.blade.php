@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pencocokan</h5>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('matching.create') }}" class="btn btn-primary">Buat Pencocokan</a>
                    @endif
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang Hilang</th>
                                    <th>Barang Temuan</th>
                                    <th>Status</th>
                                    <th>Admin</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($matchings as $matching)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $matching->lostItem->name }}</td>
                                        <td>{{ $matching->foundItem->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $matching->status === 'cocok' ? 'success' : ($matching->status === 'tidak cocok' ? 'danger' : 'warning') }} text-white">
                                                {{ ucfirst($matching->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $matching->admin->name }}</td>
                                        <td>{{ $matching->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('matching.show', $matching->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('matching.destroy', $matching->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pencocokan ini?')">Hapus</button>
                                                </form>
                                            @endif
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