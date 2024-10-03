<div class="card p-4 rounded-4 shadow" data-aos="zoom-in">
    <table id="example" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th class="align-middle">Nama</th>
                <th class="align-middle">Lokasi</th>
                <th class="align-middle">Aduan</th>
                <th class="align-middle text-center">Jenis Aduan</th>
                <th class="align-middle text-center">Skala Prioritas</th>
                <th class="align-middle text-center">Status</th>
                <th class="text-cente align-middle">Gambar</th>
                <th class="align-middle">Tanggal & Waktu</th>
            </tr>
        </thead>
    </table>
</div>

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

    // Table Riwayat
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route('getDataDoneComplaint') }}',
        columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center align-middle'
            },
            {
                data: 'user.name',
                name: 'user.name',
                className: 'align-middle'
            },
            {
                data: 'lokasi',
                name: 'lokasi',
                className: 'align-middle'
            },
            {
                data: 'text_complaint',
                name: 'text_complaint',
                className: 'align-middle'
            },
            {
                data: 'type_complaint',
                name: 'type_complaint',
                className: 'align-middle text-center'
            },
            {
                data: 'type_complaint',
                name: 'type_complaint',
                className: 'align-middle text-center',
                render: function(data, type, row) {
                    // Logika untuk menentukan skala prioritas
                    switch (data) {
                        case 'tidak urgent':
                            return 4;
                        case 'kurang urgent':
                            return 3;
                        case 'urgent':
                            return 2;
                        case 'sangat urgent':
                            return 1;
                        default:
                            return '-';
                    }
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'align-middle text-center',
                render: function(data, type, row) {
                    // Menambahkan class berdasarkan status
                    let statusClass = data === 'Selesai' ? 'text-success fw-bold' :
                        'text-danger fw-bold';
                    return '<select class="form-select status-select border-0 ' + statusClass +
                        '" data-id="' + row.id + '">' +
                        '<option value="Belum Selesai"' + (data === 'Belum Selesai' ? ' selected' :
                            '') + ' class="text-danger fw-bold">Belum Selesai</option>' +
                        '<option value="Selesai"' + (data === 'Selesai' ? ' selected' : '') +
                        ' class="text-success fw-bold">Selesai</option>' +
                        '</select>';
                }
            },
            {
                data: 'gambar',
                name: 'gambar',
                className: 'text-center align-middle',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<a href="' + '{{ asset('storage/file-gambar/') }}/' + data +
                            '" target="_blank">' +
                            '<img src="' + '{{ asset('storage/file-gambar/') }}/' + data +
                            '" width="100" style="cursor: pointer;">' +
                            '</a>';
                    }
                    return '<i class="bi bi-image fs-1"></i>';
                }
            },
            {
                data: 'created_at',
                name: 'created_at',
                className: 'align-middle',
                render: function(data, type, row) {
                    if (!data) return '';

                    let parts = data.split(' ');
                    let date = parts[0];
                    let time = parts[1];

                    let dateParts = date.split('-');

                    let formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];

                    return time + ' ' + formattedDate;
                }
            }
        ]
    });
</script>
