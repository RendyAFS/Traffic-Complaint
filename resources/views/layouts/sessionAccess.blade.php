<script>
    @if (session('status') === 'error')
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: '{{ session('message') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0D2454'
        });
    @endif
</script>
