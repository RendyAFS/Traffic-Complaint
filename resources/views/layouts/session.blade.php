<script>
    @if (session('status') === 'error')
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: '{{ session('message') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#7a0000'
        });
    @endif

    @if (session('success-formComplaint'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success-formComplaint') }}',
            confirmButtonColor: '#0B2F9F',
            confirmButtonText: 'OK'
        });
    @endif

    @if (session('error-formComplaint'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error-formComplaint') }}',
            confirmButtonColor: '#7a0000',
            confirmButtonText: 'OK'
        });
    @endif

    @if (session('success-formComplaint'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success-formComplaint') }}',
            confirmButtonColor: '#9DBDFF',
            confirmButtonText: 'OK'
        });
    @endif

    // Tampilkan pesan error jika ada
    @if (session('error-formComplaint'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error-formComplaint') }}',
            confirmButtonColor: '#9DBDFF',
            confirmButtonText: 'OK'
        });
    @endif

    // Tampilkan pesan validasi jika ada
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            confirmButtonColor: '#7a0000',
            confirmButtonText: 'OK'
        });
    @endif
</script>
