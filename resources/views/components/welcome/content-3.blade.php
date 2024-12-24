<div class="content mb-5" id="content-3" style="scroll-margin-top: 100px;">
    <div class="text-center mb-5" data-aos="fade-up">
        <span class="fw-bold fs-3 font-blue mb-4">Aduan Terbaru</span>
    </div>
    <div class="row">
        @if ($latestComplaints->isEmpty())
            <div class="col-12 text-center" data-aos="fade-up">
                <p class="fw-bold fs-4 font-soft-grey">Belum ada aduan terbaru!</p>
            </div>
        @else
            @foreach ($latestComplaints as $complaint)
            <div class="bg-light px-4 py-4 mb-3 rounded-4 shadow" data-aos="fade-up">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-send-arrow-down-fill fs-2 icon-new-complaint me-3"></i>
                    <span>{{$complaint->text_complaint}}</span>

                    <div class="ms-auto text-end">
                        <div>{{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('H:i:s') }}</div>
                        <div>{{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                <div class="ms-4">
                    <span class="fst-italic fs-7">
                        <i class="bi bi-geo-alt-fill"></i> {{$complaint->lokasi}}
                    </span>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
