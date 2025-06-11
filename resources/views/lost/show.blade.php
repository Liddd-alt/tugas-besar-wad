@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Barang Hilang</h5>
                    <div>
                        <a href="{{ route('lost.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($lost->image)
                                <img src="{{ asset('storage/image/' . $lost->image) }}" alt="{{ $lost->name }}" class="img-fluid rounded">
                            @else
                                <div class="text-center p-4 bg-light rounded">
                                    <span class="text-muted">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $lost->name }}</h4>
                            <p class="text-muted">Kategori: {{ $lost->category->name }}</p>
                            <p class="text-muted">Lokasi: {{ $lost->location }}</p>
                            <p class="text-muted">Dilaporkan oleh: {{ $lost->user->name }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Deskripsi</h5>
                        <p>{{ $lost->description }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
