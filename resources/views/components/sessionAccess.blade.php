<script>
    @if (session('status') === 'error')
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: '{{ session('message') }}',
        });
    @endif
</script>
