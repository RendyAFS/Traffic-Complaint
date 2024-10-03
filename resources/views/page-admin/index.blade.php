@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @include('components.admin.modal-upload-file-aduan')
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-up">
                <span class="fs-3 fw-bold">Input Data Aduan</span>
            </div>
            @include('components.admin.input-complaint')
        </div>
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-right">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan</span>
            </div>
            @include('components.admin.table-history-complaint')
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
                text: '{{ session('success-upload') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0D2454'
            });
        @endif
        @if (session('success-update'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Upload',
                text: '{{ session('success-upload') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0D2454'
            });
        @endif
    </script>
@endpush
