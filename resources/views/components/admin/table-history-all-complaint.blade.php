<div class="card p-4 rounded-4 border-0">
    <table id="example" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="align-middle">Nama</th>
                <th class="align-middle">Lokasi</th>
                <th class="align-middle">Aduan</th>
                <th class="align-middle text-center">Jenis Aduan</th>
                <th class="align-middle text-center">Nilai Urgensi</th>
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
    $(document).ready(function() {
        // Inisialisasi DateTime Picker untuk rentang tanggal
        flatpickr("#created_at_filter", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id"
        });

        // Inisialisasi DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details Table';
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            ajax: {
                url: '{{ route('getDataAllComplaint') }}',
                data: function(d) {
                    d.category_complaint = $('#category_complaint').val(); // Filter kategori
                    d.date_range = $('#created_at_filter').val(); // Filter tanggal
                }
            },
            columns: [{
                    data: 'user.name',
                    name: 'user.name',
                    orderable: false,
                    className: 'align-middle'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi',
                    orderable: false,
                    className: 'align-middle',
                    render: function(data, type, row) {
                        var googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' +
                            encodeURIComponent(data);
                        return '<a href="' + googleMapsUrl + '" target="_blank">' + data +
                            '</a>';
                    }
                },
                {
                    data: 'text_complaint',
                    name: 'text_complaint',
                    orderable: false,
                    className: 'align-middle'
                },
                {
                    data: 'type_complaint',
                    name: 'type_complaint',
                    orderable: false,
                    className: 'align-middle ',
                    render: function(data, type, row) {
                        if (data === 'sangat urgent') {
                            return '<span class="badge text-bgc-red">Sangat Urgent</span>';
                        } else if (data === 'urgent') {
                            return '<span class="badge text-bgc-yellow">Urgent</span>';
                        } else if (data === 'kurang urgent') {
                            return '<span class="badge text-bgc-blue">Kurang Urgent</span>';
                        } else if (data === 'tidak urgent') {
                            return '<span class="badge text-bgc-green">Tidak Urgent</span>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'type_complaint',
                    name: 'type_complaint',
                    orderable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, row) {
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
                    orderable: false,
                    className: 'align-middle ',
                    render: function(data, type, row) {
                        let statusClass =
                            data === 'Aduan Selesai' ? 'text-success fw-bold' :
                            data === 'Aduan Ditangani' ? 'text-primary fw-bold' :
                            'text-danger fw-bold';

                        return '<select class="form-select status-select border-0 ' +
                            statusClass +
                            '" data-id="' + row.id + '">' +
                            '<option value="Aduan Masuk"' + (data === 'Aduan Masuk' ?
                                ' selected' : '') +
                            ' class="text-danger fw-bold">Aduan Masuk</option>' +
                            '<option value="Aduan Ditangani"' + (data === 'Aduan Ditangani' ?
                                ' selected' : '') +
                            ' class="text-primary fw-bold">Aduan Ditangani</option>' +
                            '<option value="Aduan Selesai"' + (data === 'Aduan Selesai' ?
                                ' selected' : '') +
                            ' class="text-success fw-bold">Aduan Selesai</option>' +
                            '</select>';
                    }
                },
                {
                    data: 'gambar',
                    name: 'gambar',
                    orderable: false,
                    searchable: false,
                    className: ' align-middle',
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
                    orderable: false,
                    className: 'align-middle',
                    render: function(data, type, row) {
                        if (!data) return '';

                        // Ubah format dari ISO ke dd-MM-yyyy HH:mm:ss
                        let date = new Date(data);
                        let day = String(date.getDate()).padStart(2, '0');
                        let month = String(date.getMonth() + 1).padStart(2, '0');
                        let year = date.getFullYear();
                        let hours = String(date.getHours()).padStart(2, '0');
                        let minutes = String(date.getMinutes()).padStart(2, '0');
                        let seconds = String(date.getSeconds()).padStart(2, '0');

                        return `${hours}:${minutes}:${seconds} ${day}-${month}-${year}`;
                    }
                }
            ]
        });

        // Event untuk reload tabel ketika filter diterapkan
        $('#category_complaint, #created_at_filter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>
