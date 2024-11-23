<div class="card p-4 rounded-4 shadow" data-aos="zoom-in">
    <table id="example" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th class="w-25 align-middle">Aduan</th>
                <th class="w-25 align-middle">status</th>
                <th class="w-25 align-middle">Gambar</th>
                <th class="w-25 align-middle">Tanggal & Waktu</th>
            </tr>
        </thead>
    </table>
</div>
<script type="module">
    // Table Riwayat
    $('#example').DataTable({
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
        ajax: '{{ route('getDataRiwayat') }}',
        columns: [{
                data: 'no',
                name: 'no',
                className: 'align-middle'
            },
            {
                data: 'text_complaint',
                name: 'text_complaint',
                className: 'align-middle'
            },
            {
                data: 'status',
                name: 'status',
                className: 'align-middle',
                render: function(data, type, row) {
                    // Menambahkan class berdasarkan status
                    let statusClass =
                        data === 'Aduan Selesai' ? 'badge bg-success' :
                        data === 'Aduan Ditangani' ? 'badge bg-primary' :
                        'badge bg-danger';

                    // Mengembalikan badge sesuai status
                    return '<span class="' + statusClass + '">' + data + '</span>';
                }
            },
            {
                data: 'gambar',
                name: 'gambar',
                className: 'align-middle',
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
        ],
    });
</script>
