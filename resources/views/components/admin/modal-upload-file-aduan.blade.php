<div class="d-flex justify-content-end flex-row">
    <a href="{{ asset('storage/assets/Template-Aduan.xlsx') }}" class="btn btnc-blue me-2" download>
        <i class="bi bi-file-earmark-excel-fill"></i> Template
    </a>
    <!-- Button trigger modal -->
    <button type="button" class="btn btnc-primary" data-bs-toggle="modal" data-bs-target="#uploadfileTemplateAduan">
        <i class="bi bi-file-arrow-up-fill"></i> File
    </button>
</div>
<!-- Modal -->
<div class="modal fade" id="uploadfileTemplateAduan" tabindex="-1" aria-labelledby="uploadfileTemplateAduanLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold font-dark" id="uploadfileTemplateAduanLabel">Upload File Aduan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fileTemplateAduan" class="form-label">
                            Format File
                            <span class="text-grey fw-normal fst-italic">(xls, xlsx)</span>
                        </label>
                        <input class="form-control" type="file" id="fileTemplateAduan" name="fileTemplateAduan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btnc-red" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btnc-green" id="uploadButton">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    // FilePond instance for file upload
    const inputElement = document.getElementById('fileTemplateAduan');
    const pond = FilePond.create(inputElement);

    // Prevent default form submission
    document.getElementById('uploadForm').addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the form from submitting automatically
    });

    // Handle upload button click
    document.getElementById('uploadButton').addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default button action

        // Check if there are files to upload
        if (pond.getFiles().length > 0) {
            // Get the file extension
            const file = pond.getFiles()[0].file;
            const allowedExtensions = ['xlsx', 'xls'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            // Check if the file extension is valid
            if (!allowedExtensions.includes(fileExtension)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal',
                    text: 'Format file tidak sesuai. Hanya diperbolehkan file dengan format xlsx atau xls.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0D2454'
                });
                return; // Stop further execution
            }

            // Set options for FilePond after button is clicked
            pond.setOptions({
                server: {
                    process: {
                        url: '{{ route('upload.fileAduan.admin') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'File berhasil di-upload.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0D2454'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        onerror: (error) => {
                            console.error('Error during upload:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Upload',
                                text: 'Terjadi kesalahan selama proses upload. Silakan coba lagi.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0D2454'
                            });
                        }
                    }
                }
            });
            // Process the first file
            pond.processFile(pond.getFiles()[0]);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Terjadi kesalahan',
                text: 'Silahkan input file terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0D2454'
            });
        }
    });
</script>
