@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Buat Pencocokan Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('matching.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="lost_id" class="form-label">Barang Hilang</label>
                            <select class="form-select @error('lost_id') is-invalid @enderror" id="lost_id" name="lost_id" required>
                                <option value="">Pilih Barang Hilang</option>
                                @foreach($lostItems as $lost)
                                    <option value="{{ $lost->id }}" {{ old('lost_id') == $lost->id ? 'selected' : '' }}>
                                        {{ $lost->name }} - {{ $lost->location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lost_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="found_id" class="form-label">Barang Temuan</label>
                            <select class="form-select @error('found_id') is-invalid @enderror" id="found_id" name="found_id" required>
                                <option value="">Pilih Barang Temuan</option>
                                @foreach($foundItems as $found)
                                    <option value="{{ $found->id }}" {{ old('found_id') == $found->id ? 'selected' : '' }}>
                                        {{ $found->name }} - {{ $found->location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('found_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('matching.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Buat Pencocokan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 