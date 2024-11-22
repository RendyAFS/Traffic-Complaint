@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-right">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan Masuk</span>
            </div>
            @include('components.admin.table-history-new-complaint')
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module"></script>
@endpush
