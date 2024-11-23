@extends('layouts.app')

@section('content')
    <div class="px-1 m-1 py-1 px-md-5 m-md-5 fill-content">
        <div class="card p-4 rounded-4 shadow" data-aos="zoom-in">
            <div class="mb-3">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan Selesai</span>
            </div>
            @include('components.admin.table-history-done-complaint')
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module"></script>
@endpush
