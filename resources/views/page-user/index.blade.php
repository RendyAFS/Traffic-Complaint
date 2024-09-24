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
        // filepond
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);

        // alert upload
        @if (session('success-upload'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Upload',
                text: '{{ session('success-upload') }}', // Gunakan key yang sama
            });
        @endif


        // Table Riwayat
        // Table Riwayat
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('getDataRiwayat') }}',
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'text_complaint',
                    name: 'text_complaint'
                },
                {
                    data: 'gambar',
                    name: 'gambar',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
            ],
            responsive: true,
        });
    </script>
@endpush
