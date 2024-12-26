@extends('layouts.app')

@section('content')
    <div class="px-1 m-1 py-1 px-md-5 m-md-5 fill-content">
        <div class="mb-4">
            <form action="{{ route('form.complaint.admin') }}" method="POST" enctype="multipart/form-data" data-aos="zoom-in">
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
                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="gambar" class="form-label fw-bold">Masukkan Media <span
                                        class="text-grey fw-normal fst-italic">(png, jpg, jpeg) max 2Mb</span></label><br>
                                <input type="file" id="fileGambar" name="gambar" class="border w-100 p-3 rounded-2">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center flex-row">
                        <a href="{{ route('admin.new.complaint') }}" class="btn btnc-red me-2"><i class="bi bi-x-circle-fill"></i>
                            Reset</a>
                        <button type="submit" class="btn btnc-green"><i class="bi bi-floppy-fill"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mb-4">
            <div class="card p-4 rounded-4 shadow" data-aos="zoom-in">
                <div class="mb-3">
                    <span class="fs-3 fw-bold">Tabel Riwayat Aduan Masuk</span>
                </div>
                @include('components.admin.table-history-new-complaint')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module"></script>
@endpush
