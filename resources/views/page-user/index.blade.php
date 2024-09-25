@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="mb-3">
                <span class="fs-3 fw-bold">Input Data Aduan</span>
            </div>
            @include('components.user.input-complaint')
        </div>
        <div class="mb-4">
            <div class="mb-3">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan</span>
            </div>
            @include('components.user.table-history-complaint')
        </div>
    </div>
@endsection


@push('scripts')
    <script type="module">
        // alert upload
        @if (session('success-upload'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Upload',
                text: '{{ session('success-upload') }}', // Gunakan key yang sama
            });
        @endif
    </script>
@endpush
