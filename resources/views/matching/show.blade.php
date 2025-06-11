@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pencocokan</h5>
                    <a href="{{ route('matching.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Barang Hilang</h6>
                            <p><strong>Nama:</strong> {{ $matching->lostItem->name }}</p>
                            <p><strong>Deskripsi:</strong> {{ $matching->lostItem->description }}</p>
                            <p><strong>Lokasi:</strong> {{ $matching->lostItem->location }}</p>
                            <p><strong>Kategori:</strong> {{ $matching->lostItem->category->name }}</p>
                            <p><strong>Pelapor:</strong> {{ $matching->lostItem->user->name }}</p>
                            @if($matching->lostItem->image)
                                <img src="{{ asset('storage/image/' . $matching->lostItem->image) }}" alt="{{ $matching->lostItem->name }}" class="img-thumbnail" style="max-width: 200px;">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Barang Ditemukan</h6>
                            <p><strong>Nama:</strong> {{ $matching->foundItem->name }}</p>
                            <p><strong>Deskripsi:</strong> {{ $matching->foundItem->description }}</p>
                            <p><strong>Lokasi:</strong> {{ $matching->foundItem->location }}</p>
                            <p><strong>Kategori:</strong> {{ $matching->foundItem->category->name }}</p>
                            <p><strong>Pelapor:</strong> {{ $matching->foundItem->user->name }}</p>
                            @if($matching->foundItem->image)
                                <img src="{{ asset('storage/image/' . $matching->foundItem->image) }}" alt="{{ $matching->foundItem->name }}" class="img-thumbnail" style="max-width: 200px;">
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6>Status Pencocokan</h6>
                        <p>
                            @if($matching->status === 'cocok')
                                <span class="badge bg-success text-white">Cocok</span>
                            @elseif($matching->status === 'tidak cocok')
                                <span class="badge bg-danger text-white">Tidak Cocok</span>
                            @else
                                <span class="badge bg-warning text-white">Pending</span>
                            @endif
                        </p>
                    </div>

                    @if($matching->status === 'pending' && auth()->user()->id === $matching->lostItem->user_id)
                        <div class="mb-4">
                            <h6>Konfirmasi Kepemilikan</h6>
                            <form action="{{ route('matching.updateStatus', $matching->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_confirmation" value="1">
                                <div class="mb-3">
                                    <label class="form-label">Status:</label>
                                    <select name="status" class="form-select">
                                        <option value="cocok">Cocok</option>
                                        <option value="tidak cocok">Tidak Cocok</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                            </form>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <form action="{{ route('matching.destroy', $matching->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pencocokan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 