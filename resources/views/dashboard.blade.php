@extends('layouts.app')

@section('content')
<div class="container-xl mt-4">
    <h1 class="mb-4">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body d-flex align-items-center">
                    <span class="bg-primary text-white rounded-circle p-3">
                        <i class="ti ti-box"></i>
                    </span>
                    <div class="ms-3">
                        <div class="text-uppercase text-muted font-weight-medium small">Barang Hilang</div>
                        <div class="h4 m-0">{{ $total_lost_items }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body d-flex align-items-center">
                    <span class="bg-success text-white rounded-circle p-3">
                        <i class="ti ti-package"></i>
                    </span>
                    <div class="ms-3">
                        <div class="text-uppercase text-muted font-weight-medium small">Barang Temuan</div>
                        <div class="h4 m-0">{{ $total_found_items }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body d-flex align-items-center">
                    <span class="bg-warning text-white rounded-circle p-3">
                        <i class="ti ti-users"></i>
                    </span>
                    <div class="ms-3">
                        <div class="text-uppercase text-muted font-weight-medium small">Pengguna</div>
                        <div class="h4 m-0">{{ $total_users }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body d-flex align-items-center">
                    <span class="bg-info text-white rounded-circle p-3">
                        <i class="ti ti-link"></i>
                    </span>
                    <div class="ms-3">
                        <div class="text-uppercase text-muted font-weight-medium small">Pencocokan</div>
                        <div class="h4 m-0">{{ $total_matches }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Items -->
    <div class="row">
        <!-- Latest Lost Items -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Barang Hilang</h3>
                </div>
                <div class="card-body">
                    @if($latest_lost_items->isEmpty())
                        <div class="text-center text-muted">Belum ada data</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($latest_lost_items as $item)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        @if($item->image)
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/image/' . $item->image) }}" class="rounded" width="50" height="50" alt="{{ $item->name }}">
                                            </div>
                                        @endif
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                <a href="{{ route('lost.show', $item->id) }}" class="text-reset">{{ $item->name }}</a>
                                            </div>
                                            <div class="text-muted">
                                                {{ Str::limit($item->description, 50) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-primary text-white">{{ $item->category->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $latest_lost_items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Found Items -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Barang Temuan</h3>
                </div>
                <div class="card-body">
                    @if($latest_found_items->isEmpty())
                        <div class="text-center text-muted">Belum ada data</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($latest_found_items as $item)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        @if($item->image)
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/image/' . $item->image) }}" class="rounded" width="50" height="50" alt="{{ $item->name }}">
                                            </div>
                                        @endif
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                <a href="{{ route('found.show', $item->id) }}" class="text-reset">{{ $item->name }}</a>
                                            </div>
                                            <div class="text-muted">
                                                {{ Str::limit($item->description, 50) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-success text-white">{{ $item->category->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $latest_found_items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Matches -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pencocokan</h3>
                </div>
                <div class="card-body">
                    @if($recent_matches->isEmpty())
                        <div class="text-center text-muted">Belum ada data</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Barang Hilang</th>
                                        <th>Barang Temuan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_matches as $match)
                                        <tr>
                                            <td>
                                                <a href="{{ route('lost.show', $match->lostItem->id) }}" class="text-reset">
                                                    {{ $match->lostItem->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('found.show', $match->foundItem->id) }}" class="text-reset">
                                                    {{ $match->foundItem->name }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($match->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($match->status === 'cocok')
                                                    <span class="badge bg-success">Cocok</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Cocok</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                {{ $match->created_at->format('d M Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $recent_matches->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection