<div class="content mb-5">
    <div class="card shadow rounded-4 border-0 p-4" data-aos="zoom-in">
        <span class="text-center fw-bold fs-3 font-blue mb-4">Semua Laporan</span>
        <div class="row text-center">
            <div class="col">
                <div class="d-flex flex-column">
                    <span class="fs-1 fw-bold font-blue text-center">{{ number_format($complientWeekly) }}</span>
                    <span class="fw-normal font-dark fs-5">Laporan Masuk Minggu ini</span>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column">
                    <span class="fs-1 fw-bold font-blue text-center">{{ number_format($complinetDone) }}</span>
                    <span class="fw-normal font-dark fs-5">Laporan Sudah Selesai</span>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column">
                    <span class="fs-1 fw-bold font-blue text-center">{{ number_format($totalComplient) }}</span>
                    <span class="fw-normal font-dark fs-5">Jumlah Semua Laporan</span>
                </div>
            </div>
        </div>
    </div>
</div>
