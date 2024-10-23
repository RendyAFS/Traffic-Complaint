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
        }).then(function(result) {
            if (result.state === 'granted' || localStorage.getItem('locationAccess') === 'true') {
                document.getElementById('accessLocationButton').style.display = 'none';
                requestLocation();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi tidak aktif',
                    text: 'Silakan aktifkan lokasi untuk melanjutkan.',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Akses Lokasi',
                    confirmButtonColor: '#0D2454',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    cancleButtonColor: '#7a0000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        requestLocation();
                    }
                });

                document.getElementById('accessLocationButton').style.display = 'block';
            }
        });
    }

    function requestLocation() {
        if (navigator.geolocation) {
            Swal.fire({
                title: 'Sedang mengakses lokasi',
                text: 'Tunggu sebentar...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            navigator.geolocation.getCurrentPosition(success, error, {
                enableHighAccuracy: true,
                timeout: 500,
                maximumAge: 0
            });
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
                console.log(data);
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

                document.getElementById('lokasi').value = fullAddress || '';
                document.getElementById('accessLocationButton').style.display = 'none';
                localStorage.setItem('locationAccess', 'true');

                Swal.close();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('lokasi').value = 'Terjadi kesalahan saat mendapatkan lokasi.';

                Swal.close();
            });
    }

    function error() {
        console.error("Unable to retrieve your location.");
        document.getElementById('accessLocationButton').style.display = 'block';

        localStorage.removeItem('locationAccess');

        Swal.close();
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
