<div class="d-flex justify-content-end flex-row gap-2">
    <a href="{{ asset('storage/assets/Template-Aduan.xlsx') }}" class="btn btnc-blue" download>
        <i class="bi bi-file-earmark-excel-fill"></i> Template
    </a>
    <!-- Button trigger modal upload FIle -->
    <button type="button" class="btn btnc-primary" data-bs-toggle="modal" data-bs-target="#uploadfileTemplateAduan">
        <i class="bi bi-file-arrow-up-fill"></i> File
    </button>
</div>
<!-- Modal upload file -->
<div class="modal fade" id="uploadfileTemplateAduan" tabindex="-1" aria-labelledby="uploadfileTemplateAduanLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold font-dark" id="uploadfileTemplateAduanLabel">Upload File Aduan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data" method="POST"
                    action="{{ route('upload.fileAduan.admin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="fileTemplateAduan" class="form-label">
                            Format File
                            <span class="text-grey fw-normal fst-italic">(xls, xlsx)</span>
                        </label>
                        <input class="form-control" type="file" id="fileTemplateAduan" name="fileTemplateAduan"
                            accept=".xls,.xlsx" required>
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

