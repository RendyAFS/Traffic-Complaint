@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-up">
                <span class="fs-3 fw-bold">Input Data Aduan</span>
            </div>
            <form action="{{ route('form.complaint.user') }}" method="POST" enctype="multipart/form-data" data-aos="zoom-in">
                @csrf
                <div class="card px-4 py-4 border-0 shadow rounded-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="text-complaint" class="form-label fw-bold">Masukkan Aduan</label>
                                <textarea class="form-control" id="text-complaint" name="text-complaint" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label fw-bold">Masukkan Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    placeholder="Masukkan Lokasi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="gambar" class="form-label fw-bold">Masukkan Media
                                    <span class="text-grey fw-normal fst-italic">(png, jpg, jpeg)</span>
                                </label>
                                <input type="file" id="fileGambar" name="gambar" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center flex-row">
                        <a href="{{ route('user.index') }}" class="btn btnc-red me-2"><i class="bi bi-x-circle-fill"></i>
                            Reset</a>
                        <button class="btn btnc-blue me-2" type="button" id="cek-lokasi">
                            <i class="bi bi-geo-alt-fill"></i>
                            Cek Lokasi
                        </button>
                        <button type="submit" class="btn btnc-green" id="submitButton">
                            <i class="bi bi-floppy-fill"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-right">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan</span>
            </div>
            @include('components.user.table-history-complaint')
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        FilePond.create(document.getElementById('fileGambar'));
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

        FilePond.registerPlugin(FilePondPluginImagePreview);
        const inputElement = document.getElementById('fileGambar');
        const pond = FilePond.create(inputElement);

        pond.setOptions({
            server: {
                process: {
                    url: '{{ route('upload.gambar.user') }}',
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
                                confirmButtonColor: '#db5858',
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
                            confirmButtonColor: '#db5858',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            },
            beforeAddFile: (file) => {
                if (file.fileSize > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file melebihi batas maksimum 2 MB',
                        confirmButtonColor: '#db5858',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                return true;
            }
        });

        // Geolocation
        document.getElementById("cek-lokasi").addEventListener("click", function() {
            // Cek status izin geolokasi
            navigator.permissions.query({
                name: 'geolocation'
            }).then(function(permissionStatus) {
                if (permissionStatus.state === 'granted') {
                    // Jika izin sudah diberikan, langsung dapatkan lokasi
                    getGeolocation();
                } else if (permissionStatus.state === 'prompt') {
                    // Jika izin belum ditentukan, tampilkan konfirmasi menggunakan Swal
                    Swal.fire({
                        title: "Aktifkan Lokasi",
                        text: "Izinkan akses lokasi untuk mendapatkan informasi lokasi Anda?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Ya, aktifkan",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Minta izin geolokasi dari pengguna
                            getGeolocation();
                        }
                    });
                } else if (permissionStatus.state === 'denied') {
                    // Jika izin sudah ditolak, beri tahu pengguna untuk mengaktifkan izin
                    Swal.fire("Izin Ditolak",
                        "Akses lokasi telah ditolak. Aktifkan izin lokasi di pengaturan browser Anda.",
                        "error");
                }
            });
        });

        function getGeolocation() {
            // Tampilkan loading Swal saat pengambilan lokasi dimulai
            Swal.fire({
                title: "Mengambil Lokasi...",
                text: "Harap tunggu sebentar.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                Swal.fire("Geolocation tidak didukung", "Browser Anda tidak mendukung geolocation.", "error");
            }
        }

        function showPosition(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;

            // Menggunakan Nominatim API untuk reverse geocoding
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&addressdetails=1`
                    )
                .then(response => response.json())
                .then(data => {
                    let address = data.address;
                    let lokasiText =
                        `${address.road || ''}, ${address.suburb || ''}, ${address.city || address.town || address.village || ''}, ${address.state || ''}, ${address.postcode || ''}`;
                    document.getElementById("lokasi").value = lokasiText.trim();

                    // Menutup Swal loading dan menampilkan pesan sukses
                    Swal.fire("Berhasil", "Lokasi berhasil didapatkan!", "success");
                })
                .catch(error => {
                    console.error("Error fetching the location:", error);
                    Swal.fire("Gagal", "Gagal mendapatkan lokasi, silakan coba lagi.", "error");
                });
        }

        function showError(error) {
            let errorMessage;
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Anda menolak permintaan lokasi.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "Permintaan lokasi waktu habis.";
                    break;
                default:
                    errorMessage = "Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
            Swal.fire("Gagal", errorMessage, "error");
        }


        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->has('gambar'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan Aduan',
                    text: '{{ $errors->first('gambar') }}',
                    confirmButtonColor: '#db5858',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush
