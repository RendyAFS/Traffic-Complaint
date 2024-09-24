<form action="{{ route('form-complaint-admin') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card px-4 py-4 border-0 shadow-sm">
        <div class="mb-3">
            <label for="text-complaint" class="form-label fw-bold">Masukkan Aduan</label>
            <textarea class="form-control" id="text-complaint" name="text-complaint" rows="3" required></textarea>
        </div>

        <label for="file-gambar" class="form-label fw-bold">Masukkan Media
            <span class="text-grey fw-normal fst-italic">(png, jpg, jpeg)</span>
        </label>
        <input type="file" id="file-gambar" name="file-gambar" />

        <div class="d-flex justify-content-center">
            <button type="reset" class="btn btn-danger me-2">Reset</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </div>
</form>
