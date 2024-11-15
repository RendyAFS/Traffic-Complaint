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
                                    placeholder="Masukkan Lokasi" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="gambar" class="form-label fw-bold">Masukkan Media <span
                                        class="text-grey fw-normal fst-italic">(png, jpg, jpeg) max 2Mb</span></label><br>
                                <input type="file" id="fileGambar" name="gambar" class="border w-100 p-3 rounded-2"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center flex-row">
                        <a href="{{ route('user.index') }}" class="btn btnc-red me-2"><i class="bi bi-x-circle-fill"></i>
                            Reset</a>
                        <button class="btn btnc-blue me-2" type="button" id="cek-lokasi"><i class="bi bi-geo-alt-fill"></i>
                            Cek Lokasi</button>
                        <button type="submit" class="btn btnc-green" id="submitButton"><i class="bi bi-floppy-fill"></i>
                            Simpan</button>
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
        @if (session('success-upload'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success-upload') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: '{{ $error }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endforeach
        @endif

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
    </script>
@endpush
