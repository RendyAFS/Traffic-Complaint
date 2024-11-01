@if (Route::is('indexLandingPage'))
    <footer class="footer p-5">
        <div class="warp-footer">
            <div class="d-flex justify-content-around">
                <div class="footer-1 px-5">
                    <div class="mb-4">
                        <a class="navbar-brand fs-4 font-white fw-bold" href="{{ url('/') }}">
                            Traffic Complaint
                        </a>
                    </div>
                    <br>
                    <span class="font-white">
                        Laporkan Masalah Anda, Kami Siap Menindaklanjuti
                        Bersama Wujudkan Solusi dan Perubahan Nyata untuk
                        Lingkungan yang Lebih Baik!"
                    </span>
                </div>
                <div class="footer-2">
                    <ul class="link-footer-1">
                        <li>Beranda</li>
                        <li>Laporkan Masalah</li>
                        <li>Bantuan</li>
                        <li>Tentang Kami</li>
                    </ul>
                </div>
                <div class="footer-3">
                    <ul class="link-footer-2">
                        <li><img src="{{ asset('storage/assets/icon-x.png') }}" alt="icon-x" class="me-2"> X</li>
                        <li><img src="{{ asset('storage/assets/icon-instagram.png') }}" alt="icon-instagram"
                                class="me-2"> Instagram</li>
                        <li><img src="{{ asset('storage/assets/icon-facebook.png') }}" alt="icon-facebook"
                                class="me-2"> Facebook</li>
                        <li><img src="{{ asset('storage/assets/icon-youtube.png') }}" alt="icon-youtube" class="me-2">
                            Youtube</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="end-footer">
        <div class="text-center">
            <span class="fst-italic fw-bold">&copy;Traffic Complaint {{ date('Y') }}</span>
        </div>
    </div>
@endif
