@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-up">
                <span class="fs-3 fw-bold">Input Data Aduan</span>
            </div>
            @include('components.user.input-complaint')
        </div>
        <div class="mb-4">
            <div class="mb-3" data-aos="fade-right">
                <span class="fs-3 fw-bold">Tabel Riwayat Aduan</span>
            </div>
            @include('components.user.table-history-complaint')
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        checkLocationPermission();
    });

    function checkLocationPermission() {
        navigator.permissions.query({
                name: 'geolocation'
            })
            .then(function(result) {
                if (result.state === 'granted') {
                    document.getElementById('accessLocationButton').style.display = 'none';
                    requestLocation(); // Panggil fungsi requestLocation jika izin sudah diberikan
                } else {
                    document.getElementById('accessLocationButton').style.display = 'block';
                    document.getElementById('submitButton').disabled = true;
                }
            });
    }

    function requestLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error);
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    }

    function success(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json&addressdetails=1&accept-language=id`
            )
            .then(response => response.json())
            .then(data => {
                console.log(data); // Untuk debugging
                let fullAddress = '';

                if (data.address) {
                    let street = data.address.road || '';
                    let houseNumber = data.address.house_number || '';
                    let suburb = data.address.suburb || '';
                    let village = data.address.village || '';
                    let cityDistrict = data.address.city_district || '';
                    let city = data.address.city || data.address.town || '';
                    let state = data.address.state || '';
                    let postalCode = data.address.postcode || '';

                    fullAddress =
                        `${street} ${houseNumber}, ${suburb || village}, Kec. ${cityDistrict}, ${city}, ${state}, ${postalCode}`
                        .trim();
                }

                // Mengisi input lokasi tanpa fallback
                document.getElementById('lokasi').value = fullAddress || '';

                // Meng-enable tombol simpan
                document.getElementById('submitButton').disabled = false;

                // Sembunyikan tombol akses lokasi
                document.getElementById('accessLocationButton').style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('lokasi').value = 'Terjadi kesalahan saat mendapatkan lokasi.';
            });
    }

    function error() {
        console.error("Unable to retrieve your location.");
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Silahkan aktifkan lokasi',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        document.getElementById('submitButton').disabled = true;
        document.getElementById('accessLocationButton').style.display = 'block';
    }
</script>

@push('scripts')
    <script type="module">
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
    </script>
@endpush
