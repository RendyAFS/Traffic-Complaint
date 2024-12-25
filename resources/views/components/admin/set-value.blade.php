<!-- Button fixed di kanan tengah menggunakan utility Bootstrap -->
<button
    class="btn btn-danger btn-setvalue  position-fixed top-50 end-0 translate-middle-y z-index-1050 d-flex align-items-center justify-content-center"
    type="button" data-bs-toggle="modal" data-bs-target="#staticModal" aria-controls="staticModal">
    <i class="bi bi-gear-fill"></i>
</button>

<!-- Modal content -->
<div class="modal fade" id="staticModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bgc-red d-flex justify-content-between flex-row">
                <h5 class="modal-title font-white" id="staticModalLabel">Set Value Konteks</h5>
                <button type="button" class="btn btn-transparant text-white border-0" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div>
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                                type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                Waktu
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                type="button" role="tab" aria-controls="tab2" aria-selected="false">
                                Lokasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                type="button" role="tab" aria-controls="tab3" aria-selected="false">
                                People
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4"
                                type="button" role="tab" aria-controls="tab4" aria-selected="false">
                                Kondisi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab5-tab" data-bs-toggle="tab" data-bs-target="#tab5"
                                type="button" role="tab" aria-controls="tab5" aria-selected="false">
                                Object
                            </button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane py-3 fade show active" id="tab1" role="tabpanel"
                            aria-labelledby="tab1-tab">
                            <div class="d-flex flex-row justify-content-end my-3 gap-2 flex-wrap">
                                <button id="reload-waktu" class="btn btnc-blue ml-2"><i
                                        class="bi bi-arrow-clockwise"></i></button>
                                <button id="add-waktu" class="btn btnc-red"><i class="bi bi-plus-circle"></i></button>
                            </div>
                            <div id="waktu-content"></div>
                            <div id="waktu-table"></div> <!-- Table div -->
                        </div>
                        <div class="tab-pane py-3 fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <div class="d-flex flex-row justify-content-end my-3 gap-2 flex-wrap">
                                <button id="reload-lokasi" class="btn btnc-blue ml-2"><i
                                        class="bi bi-arrow-clockwise"></i></button>
                                <button id="add-lokasi" class="btn btnc-red"><i
                                        class="bi bi-plus-circle"></i></button>
                            </div>
                            <div id="lokasi-content"></div>
                            <div id="lokasi-table"></div> <!-- Table div -->
                        </div>
                        <div class="tab-pane py-3 fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            <div class="d-flex flex-row justify-content-end my-3 gap-2 flex-wrap">
                                <button id="reload-people" class="btn btnc-blue ml-2"><i
                                        class="bi bi-arrow-clockwise"></i></button>
                                <button id="add-people" class="btn btnc-red"><i
                                        class="bi bi-plus-circle"></i></button>
                            </div>
                            <div id="people-content"></div>
                            <div id="people-table"></div> <!-- Table div -->
                        </div>
                        <div class="tab-pane py-3 fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                            <div class="d-flex flex-row justify-content-end my-3 gap-2 flex-wrap">
                                <button id="reload-kondisi" class="btn btnc-blue ml-2"><i
                                        class="bi bi-arrow-clockwise"></i></button>
                                <button id="add-kondisi" class="btn btnc-red"><i
                                        class="bi bi-plus-circle"></i></button>
                            </div>
                            <div id="kondisi-content"></div>
                            <div id="kondisi-table"></div> <!-- Table div -->
                        </div>
                        <div class="tab-pane py-3 fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                            <div class="d-flex flex-row justify-content-end my-3 gap-2 flex-wrap">
                                <button id="reload-object" class="btn btnc-blue ml-2"><i
                                        class="bi bi-arrow-clockwise"></i></button>
                                <button id="add-object" class="btn btnc-red"><i
                                        class="bi bi-plus-circle"></i></button>
                            </div>
                            <div id="object-content"></div>
                            <div id="object-table"></div> <!-- Table div -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Reload Waktu table
        $(document).on('click', '#reload-waktu', function() {
            loadData('Waktu'); // Reload the Waktu tab's data
        });

        // Reload Lokasi table
        $(document).on('click', '#reload-lokasi', function() {
            loadData('Lokasi'); // Reload the Lokasi tab's data
        });

        // Reload People table
        $(document).on('click', '#reload-people', function() {
            loadData('People'); // Reload the People tab's data
        });

        // Reload Kondisi table
        $(document).on('click', '#reload-kondisi', function() {
            loadData('Kondisi'); // Reload the Kondisi tab's data
        });

        // Reload Object table
        $(document).on('click', '#reload-object', function() {
            loadData('Object'); // Reload the Object tab's data
        });

        // Fungsi untuk menampilkan form input ketika klik tombol "Add"
        function showInputForm(konteks) {
            // Menghapus form input lama jika ada
            $('#new-value-form').remove();

            // Menambahkan form input baru untuk menambah key-value
            let inputForm = `
            <div id="new-value-form">
                <label>Key</label>
                <input type="text" id="new-key" class="form-control">
                <label>Value</label>
                <input type="text" id="new-value" class="form-control">
                <div class="my-3 d-flex justify-content-center">
                    <button class="btn btn-success px-5" id="save-new-value">Save</button>
                </div>
            </div>
        `;
            $(`#${konteks.toLowerCase()}-content`).append(inputForm);
        }

        // Fungsi untuk menutup form input
        function closeInputForm(konteks) {
            $('#new-value-form').remove(); // Menghapus form input
            // Tidak ada perubahan pada icon karena tetap bi-plus-circle
        }

        // Menangani klik tombol "Add" untuk setiap tab
        $('#add-waktu').click(function() {
            let konteks = 'Waktu';
            if ($('#new-value-form').length) {
                closeInputForm(konteks); // Menutup form jika sudah terbuka
            } else {
                showInputForm(konteks); // Menampilkan form input
                // Tidak ada perubahan icon
            }
        });

        $('#add-lokasi').click(function() {
            let konteks = 'Lokasi';
            if ($('#new-value-form').length) {
                closeInputForm(konteks);
            } else {
                showInputForm(konteks);
                // Tidak ada perubahan icon
            }
        });

        $('#add-people').click(function() {
            let konteks = 'People';
            if ($('#new-value-form').length) {
                closeInputForm(konteks);
            } else {
                showInputForm(konteks);
                // Tidak ada perubahan icon
            }
        });

        $('#add-kondisi').click(function() {
            let konteks = 'Kondisi';
            if ($('#new-value-form').length) {
                closeInputForm(konteks);
            } else {
                showInputForm(konteks);
                // Tidak ada perubahan icon
            }
        });

        $('#add-object').click(function() {
            let konteks = 'Object';
            if ($('#new-value-form').length) {
                closeInputForm(konteks);
            } else {
                showInputForm(konteks);
                // Tidak ada perubahan icon
            }
        });


        // Menambahkan CSRF token ke setiap request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fungsi untuk menyimpan data baru
        $(document).on('click', '#save-new-value', function() {
            // Mendapatkan konteks (tab aktif)
            let konteks = $('ul.nav-tabs .nav-link.active').text().trim();

            // Mendapatkan key dan value dari input
            let key = $('#new-key').val();
            let value = $('#new-value').val();

            // Validasi jika key dan value sudah diisi
            if (key && value) {
                let newData = {};
                newData[key] = value; // Menambahkan key-value ke objek newData

                // Memastikan newData adalah objek dan memiliki properti
                if (Object.keys(newData).length > 0) {
                    // Mengirim data untuk disimpan ke server
                    $.ajax({
                        url: '/set-values/new',
                        method: 'POST',
                        data: {
                            konteks: konteks,
                            value: JSON.stringify(newData), // Mengirim value sebagai JSON
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // Pastikan CSRF token ada
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Jika key sudah ada, tampilkan Swal.fire dengan error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'The key already exists.',
                                    showConfirmButton: false,
                                    timer: 2000 // 2 seconds
                                });
                            } else {
                                // Jika berhasil disimpan, tampilkan Swal.fire dengan success
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false, // Hides the confirm button
                                    timer: 2000 // Automatically closes after 2 seconds
                                });

                                $('#new-value-form')
                                    .remove(); // Menghapus form setelah data disimpan
                                loadData(konteks); // Reload data tab setelah penambahan
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while saving data.',
                                showConfirmButton: false,
                                timer: 2000 // Automatically closes after 2 seconds
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please fill both fields.',
                        showConfirmButton: false, // Hides the confirm button
                        timer: 2000 // Automatically closes after 2 seconds
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please fill both fields.',
                    showConfirmButton: false, // Hides the confirm button
                    timer: 2000 // Automatically closes after 2 seconds
                });
            }
        });


        // Fungsi untuk mengambil dan menampilkan data dalam bentuk tabel
        loadData('Waktu');
        loadData('Lokasi');
        loadData('People');
        loadData('Kondisi');
        loadData('Object');

        function loadData(konteks) {
            $.get('/set-values', {
                konteks: konteks
            }, function(data) {
                let content = '';
                if (data && data.value) {
                    let parsedValue = typeof data.value === 'string' ? JSON.parse(data.value) : data
                        .value;

                    if (parsedValue && typeof parsedValue === 'object' && !Array.isArray(parsedValue)) {
                        content += `
                <table id="data-table-${konteks}" class="table">
                    <thead>
                        <tr>
                            <th style="width: 37.5%;">Key</th>
                            <th style="width: 37.5%;">Value</th>
                            <th style="width: 25%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                `;

                        $.each(parsedValue, function(key, val) {
                            content += `
                    <tr data-konteks="${data.konteks}" data-key="${key}">
                        <td>
                            <input type="text" value="${key}" class="form-control key-input" data-konteks="${data.konteks}" data-key="${key}" style="display:none;">
                            <span class="key-display">${key}</span>
                        </td>
                        <td>
                            <input type="text" value="${val}" class="form-control value-input" data-konteks="${data.konteks}" data-key="${key}" style="display:none;">
                            <span class="value-display">${val}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-row gap-2 flex-wrap">
                                <button class="btn btn-warning edit-btn"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></button>
                                <button class="btn btn-success update-btn" style="display:none;"><i class="bi bi-check2"></i></button>
                                <button class="btn btn-danger cancel-btn" style="display:none;"><i class="bi bi-x"></i></button>
                            </div>
                        </td>
                    </tr>
                    `;
                        });

                        content += `</tbody></table>`;

                        // Tempatkan konten tabel ke dalam elemen
                        $(`#${konteks.toLowerCase()}-table`).html(content);

                        // Hancurkan DataTable jika sudah ada
                        if ($.fn.dataTable.isDataTable(`#data-table-${konteks}`)) {
                            $(`#data-table-${konteks}`).DataTable()
                        .destroy(); // Hancurkan DataTable yang ada
                        }

                        // Inisialisasi DataTable setelah data dimuat
                        $(`#data-table-${konteks}`).DataTable({
                            "pageLength": 10,
                            "lengthChange": false,
                            "info": true,
                            "searching": true
                        });

                        // Menambahkan event listeners untuk tombol aksi setelah tabel diinisialisasi
                        addActionEventListeners(konteks);
                    } else {
                        content = `<p>No data available</p>`;
                    }
                } else {
                    content = `<p>No data available</p>`;
                }
            });
        }

        $('#myTab a').on('shown.bs.tab', function(e) {
            var konteks = $(e.target).attr('href').substring(1); // Ambil id tab yang baru
            loadData(konteks); // Panggil fungsi loadData untuk memuat data pada tab yang baru
        });



        // Edit button click handler
        $(document).on('click', '.edit-btn', function() {
            let parentRow = $(this).closest('tr');
            let inputFieldKey = parentRow.find('.key-input');
            let valueDisplayKey = parentRow.find('.key-display');
            let inputFieldValue = parentRow.find('.value-input');
            let valueDisplayValue = parentRow.find('.value-display');
            let saveButton = parentRow.find('.update-btn');
            let cancelButton = parentRow.find('.cancel-btn');

            // Hide the display values and show input fields
            valueDisplayKey.hide();
            inputFieldKey.show();
            valueDisplayValue.hide();
            inputFieldValue.show();
            saveButton.show();
            cancelButton.show();
            $(this).hide(); // Hide the edit button
            parentRow.find('.delete-btn').hide(); // Hide the delete button while editing
        });

        // Cancel button click handler
        $(document).on('click', '.cancel-btn', function() {
            let parentRow = $(this).closest('tr');
            let inputFieldKey = parentRow.find('.key-input');
            let valueDisplayKey = parentRow.find('.key-display');
            let inputFieldValue = parentRow.find('.value-input');
            let valueDisplayValue = parentRow.find('.value-display');
            let saveButton = parentRow.find('.update-btn');
            let editButton = parentRow.find('.edit-btn');
            let deleteButton = parentRow.find('.delete-btn');
            let cancelButton = parentRow.find('.cancel-btn');

            // Hide the input fields and show the original values
            inputFieldKey.hide();
            valueDisplayKey.show();
            inputFieldValue.hide();
            valueDisplayValue.show();
            saveButton.hide();
            cancelButton.hide();
            editButton.show(); // Show the edit button again
            deleteButton.show(); // Show the delete button again
        });

        // Save button click handler (Edit)
        $(document).on('click', '.update-btn', function() {
            let parentRow = $(this).closest('tr');
            let oldKey = parentRow.data('key');
            let newKey = parentRow.find('.key-input').val();
            let newValue = parentRow.find('.value-input').val();
            let konteks = parentRow.data('konteks');

            if (newKey !== '' && newValue !== '') {
                // Send updated key and value to the server
                $.post('/set-values/update', {
                    konteks: konteks,
                    key: oldKey, // Send the old key to identify the key to update
                    new_key: newKey, // Send the new key
                    new_value: newValue
                }, function(response) {
                    if (response.message === 'The new key already exists!') {
                        // Show Swal.fire alert if new key already exists
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'The new key already exists!',
                            showConfirmButton: false,
                            timer: 2000 // 2 seconds
                        });
                    } else {
                        // Use Swal.fire for success alert with no confirmation
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000 // 2 seconds
                        });

                        loadData(konteks); // Reload data after update
                    }
                }).fail(function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating data.',
                        showConfirmButton: false,
                        timer: 2000 // 2 seconds
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Key and value cannot be empty',
                    showConfirmButton: false,
                    timer: 2000 // 2 seconds
                });
            }
        });


        // Delete button click handler (Delete with confirmation)
        $(document).on('click', '.delete-btn', function() {
            let parentRow = $(this).closest('tr');
            let key = parentRow.data('key');
            let konteks = parentRow.data('konteks');

            // Confirm deletion using Swal
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: "#58db63", // Correct property name
                cancelButtonText: 'No, keep it',
                cancelButtonColor: "#db5858" // Corrected property name
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion if confirmed
                    $.post('/set-values/delete', {
                        konteks: konteks,
                        key: key
                    }, function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000 // 2 seconds
                        });
                        loadData(konteks); // Reload data after deletion
                    });
                }
            });
        });
    });
</script>
