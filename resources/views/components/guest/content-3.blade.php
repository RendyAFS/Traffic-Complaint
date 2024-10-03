<div class="content mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <span class="fw-bold fs-3 font-blue mb-4">Aduan Terbaru</span>
    </div>
    <div class="row">
        @foreach ($latestComplaints as $complient)
            <div class="col-lg-4 mb-4">
                <div class="card h-100 rounded-4 border-0 shadow" data-aos="flip-left">
                    @if ($complient->gambar)
                        <!-- Menampilkan gambar jika tersedia -->
                        <img src="{{ asset('storage/file-gambar/' . $complient->gambar) }}" alt="{{ $complient->gambar }}"
                            class="card-img-top img-fluid rounded-top-4" style="object-fit: cover; height: 250px;">
                    @else
                        <!-- Placeholder jika gambar null -->
                        <div class="d-flex justify-content-center align-items-center rounded-4"
                            style="height: 250px; background-color: #f8f9fa;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="fw-bold">{{ Str::words($complient->text_complaint, 5) }}</span>
                        <div class="d-flex justify-content-end">
                            <a href="#" class="font-blue fw-bold" data-bs-toggle="modal" data-bs-target="#complaintModal{{ $complient->id }}">Read More</a><br>
                        </div>
                        <span class="fs-6 fst-italic">{{ $complient->created_at->translatedFormat('d-F-Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="complaintModal{{ $complient->id }}" tabindex="-1" aria-labelledby="complaintModalLabel{{ $complient->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="complaintModalLabel{{ $complient->id }}">Detail Aduan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($complient->gambar)
                                <img src="{{ asset('storage/file-gambar/' . $complient->gambar) }}" alt="{{ $complient->gambar }}"
                                    class="img-fluid mb-3" style="object-fit: cover; width: 100%; max-height: 400px;">
                            @else
                                <div class="d-flex justify-content-center align-items-center mb-3"
                                    style="height: 250px; background-color: #f8f9fa;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                            <p>{{ $complient->text_complaint }}</p>
                            <p class="fs-6 fst-italic">Tanggal Aduan: {{ $complient->created_at->translatedFormat('d-F-Y') }}</p>
                            <p class="fs-6 fst-italic">Loaksi: {{ $complient->lokasi }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btnc-red" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
