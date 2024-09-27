<div class="d-flex justify-content-end">
    <a href="" class="btn btnc-blue me-2"><i class="bi bi-file-earmark-excel-fill"></i> Template</a>
    <!-- Button trigger modal -->
    <button type="button" class="btn btnc-primary" data-bs-toggle="modal" data-bs-target="#uploadfileTemplateAduan">
        <i class="bi bi-file-arrow-up-fill"></i> File
    </button>
</div>
<!-- Modal -->
<div class="modal fade" id="uploadfileTemplateAduan" tabindex="-1" aria-labelledby="uploadfileTemplateAduanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="uploadfileTemplateAduanLabel">Upload File Aduan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fileTemplateAduan" class="form-label">Upload File Aduan</label>
                    <input class="form-control" type="file" id="fileTemplateAduan" name="fileTemplateAduan">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnc-red" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btnc-green">Upload</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // FilePond instance for image upload
    const inputElement = document.getElementById('fileTemplateAduan');
    const pond = FilePond.create(inputElement);

    // Configure FilePond to handle server upload
    pond.setOptions({
        server: {
            process: {
                url: '{{ route('upload.fileAduan.admin') }}', // Route to handle image upload
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                },
                onload: (response) => {
                    console.log('File uploaded successfully:', response);
                },
                onerror: (error) => {
                    console.error('Error during upload:', error);
                }
            }
        }
    });
</script>
