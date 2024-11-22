@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @include('components.admin.action-button')
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-up">
                <span class="fs-3 fw-bold">Dashboard</span>
            </div>
            <div class="row">
                @foreach ($statuses as $index => $status)
                    <div class="col-12 col-xl-3 mb-3">
                        <div class="card border-0 shadow-sm p-3 rounded-4" style="width: 100%" data-aos="fade-right"
                            data-aos-delay="{{ $index * 300 }}">
                            <div class="card-body">
                                <p class="card-title fs-5 d-flex align-items-center gap-2">
                                    @if ($status['status'] === 'Aduan Masuk')
                                        <i class="bi bi-arrow-down-circle-fill text-danger"></i>
                                        <span class="badge text-bg-danger">{{ $status['status'] }}</span>
                                    @elseif ($status['status'] === 'Aduan Ditangani')
                                        <i class="bi bi-exclamation-circle-fill text-primary"></i>
                                        <span class="badge text-bg-primary">{{ $status['status'] }}</span>
                                    @elseif ($status['status'] === 'Aduan Selesai')
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="badge text-bg-success">{{ $status['status'] }}</span>
                                    @endif
                                </p>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Jumlah</h6>
                                <p class="card-text fs-3 text-end fw-bold">{{ $status['total'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Card untuk Total Semua Aduan -->
                <div class="col-12 col-xl-3 mb-3">
                    <div class="card border-0 shadow p-3 rounded-4 bg-warning" style="width: 100%" data-aos="fade-right"
                            data-aos-delay="900">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Total Semua Aduan</h5>
                            <h6 class="card-subtitle mb-2">Total</h6>
                            <p class="card-text fs-3 text-end fw-bold">{{ $totalComplaints }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.admin.table-history-all-complaint  ')
    @endsection

    @push('scripts')
        <script type="module">
            $(document).on('change', '.status-select', function() {
                var status = $(this).val();
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('update.status') }}', // URL untuk mengupdate status
                    method: 'POST',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}' // Pastikan token CSRF disertakan
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#0D2454'
                        }).then(() => {
                            window.location.href = response.redirect; // Redirect ke halaman admin
                        });
                    },
                    error: function(xhr) {
                        // Tindakan jika ada kesalahan
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Gagal memperbarui status.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#0D2454'
                        });
                    }
                });
            });
        </script>
    @endpush
