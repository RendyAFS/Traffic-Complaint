<form action="{{ route('form-complaint-admin') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card px-4 py-4 border-0 shadow-sm">
        <div class="mb-3">
            <label for="text-complaint" class="form-label fw-bold">Masukkan Aduan</label>
            <textarea class="form-control" id="text-complaint" name="text-complaint" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label fw-bold">Masukkan Media
                <span class="text-grey fw-normal fst-italic">(png, jpg, jpeg)</span>
            </label>
            <input type="file" id="gambar" name="gambar" />
        </div>

        <div class="d-flex justify-content-center">
            <a href="{{route('user.index')}}" class="btn btn-danger me-2">Reset</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </div>
</form>

<script type="module">
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // FilePond instance for image upload
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);

    // Configure FilePond to handle server upload
    pond.setOptions({
        server: {
            process: {
                url: '{{ route('upload.gambar.admin') }}', // Route to handle image upload
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
