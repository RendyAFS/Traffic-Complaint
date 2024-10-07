<form action="{{ route('form.complaint.user') }}" method="POST" enctype="multipart/form-data" data-aos="zoom-in">
    @csrf
    <div class="card px-4 py-4 border-0 shadow rounded-4">
        <div class="mb-3">
            <label for="text-complaint" class="form-label fw-bold">Masukkan Aduan</label>
            <textarea class="form-control" id="text-complaint" name="text-complaint" rows="3" required></textarea>
        </div>
        <div class="mb-3 d-none">
            <label for="lokasi" class="form-label fw-bold">Masukkan Lokasi</label>
            <input class="form-control" id="lokasi" name="lokasi" rows="3" required />
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label fw-bold">Masukkan Media
                <span class="text-grey fw-normal fst-italic">(png, jpg, jpeg)</span>
            </label>
            <input type="file" id="fileGambar" name="gambar" />
        </div>

        <div class="d-flex justify-content-center">
            <a href="{{ route('user.index') }}" class="btn btnc-red me-2"><i class="bi bi-x-circle-fill"></i> Reset</a>
            <button type="button" class="btn btnc-green me-2" id="accessLocationButton" onclick="requestLocation()">
                <i class="bi bi-geo-alt-fill"></i> Akses Lokasi
            </button>
            <button type="submit" class="btn btnc-green" id="submitButton" disabled>
                <i class="bi bi-floppy-fill"></i> Simpan
            </button>
        </div>
    </div>
</form>
<!-- Script FilePond -->
<script type="module">
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // FilePond instance for image upload
    const inputElement = document.getElementById('fileGambar');
    const pond = FilePond.create(inputElement);

    // Configure FilePond to handle server upload
    pond.setOptions({
        server: {
            process: {
                url: '{{ route('upload.gambar.user') }}', // Route to handle image upload
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
