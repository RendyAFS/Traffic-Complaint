<div class="card p-4 rounded-4 shadow" data-aos="zoom-in">
    <table id="example" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th class="w-50 align-middle">Aduan</th>
                <th class="w-25 text-center align-middle">Gambar</th>
                <th class="text-center align-middle">Tanggal & Waktu</th>
            </tr>
        </thead>
    </table>
</div>
<script type="module">
    // Table Riwayat
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route('getDataRiwayat') }}',
        columns: [{
                data: 'no',
                name: 'no',
                className: 'text-center',
                className: 'align-middle text-center'
            },
            {
                data: 'text_complaint',
                name: 'text_complaint',
                className: 'align-middle'
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
        ],
    });
</script>
