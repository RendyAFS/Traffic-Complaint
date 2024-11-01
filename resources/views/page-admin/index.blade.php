@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @include('components.admin.modal-upload-file-aduan')
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-up">
                <span class="fs-3 fw-bold">Input Data Aduan</span>
            </div>
            <form action="{{ route('form.complaint.admin') }}" method="POST" enctype="multipart/form-data" data-aos="zoom-in">
                @csrf
                <div class="card px-4 py-4 border-0 shadow rounded-4">
                    <div class="mb-3">
                        <label for="text-complaint" class="form-label fw-bold">Masukkan Aduan</label>
                        <textarea class="form-control" id="text-complaint" name="text-complaint" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label fw-bold">Masukkan Lokasi</label>
                        <input class="form-control" id="lokasi" name="lokasi" rows="3" required></input>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-bold">Masukkan Media
                            <span class="text-grey fw-normal fst-italic">(png, jpg, jpeg)</span>
                        </label>
                        <input type="file" id="fileGambar" name="gambar" />
                    </div>

                    <div class="d-flex justify-content-center flex-row">
                        <a href="{{ route('admin.index') }}" class="btn btnc-red me-2"><i class="bi bi-x-circle-fill"></i>
                            Reset</a>
                        <button type="submit" class="btn btnc-green"><i class="bi bi-floppy-fill"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-right">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan</span>
            </div>
            @include('components.admin.table-history-complaint')
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // FilePond instance for image upload
        const inputElement = document.getElementById('fileGambar');
        const pond = FilePond.create(inputElement);

        pond.setOptions({
            server: {
                process: {
                    url: '{{ route('upload.gambar.admin') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Failed',
                                text: data.error,
                                confirmButtonColor: '#7a0000',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            console.log('File uploaded successfully:', response);
                        }
                    },
                    onerror: (error) => {
                        console.error('Error detected during upload:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: 'File tidak sesuai dengan ketentuan atau terjadi kesalahan pada server',
                            confirmButtonColor: '#7a0000',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            },
            beforeAddFile: (file) => {
                // Validate file size before adding it to the pond
                if (file.fileSize > 2 * 1024 * 1024) { // 2 MB size limit
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file melebihi batas maksimum 2 MB',
                        confirmButtonColor: '#7a0000',
                        confirmButtonText: 'OK'
                    });
                    return false; // Prevents the file from being added
                }
                return true; // Allows file to be added if size is under limit
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->has('gambar'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan Aduan',
                    text: '{{ $errors->first('gambar') }}',
                    confirmButtonColor: '#7a0000',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        // alert upload
        @if (session('success-upload'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Upload',
                text: '{{ session('success-upload') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0D2454'
            });
        @endif
        @if (session('success-update'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Upload',
                text: '{{ session('success-upload') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0D2454'
            });
        @endif
    </script>
@endpush
