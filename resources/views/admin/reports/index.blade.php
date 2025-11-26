@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')

@php
    $grandTotal = $orders->sum('total_price');
    $totalItems = 0;
    foreach ($orders as $o) {
        $totalItems += $o->items->sum('qty');
    }
    
    // Statistik tambahan
    $selesai = $orders->where('status', 'selesai')->count();
    $diproses = $orders->where('status', 'diproses')->count();
    $averageOrder = $orders->count() > 0 ? $grandTotal / $orders->count() : 0;
@endphp

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="bi bi-graph-up text-primary me-2"></i>Laporan Penjualan
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-calendar3 me-1"></i>
                        Periode: {{ now()->format('d F Y') }}
                    </p>
                </div>
                
                <div class="d-flex gap-2 flex-wrap">
                    <button id="downloadPDF" class="btn btn-danger shadow-sm">
                        <i class="bi bi-file-pdf me-2"></i>Download PDF
                    </button>
                    <button onclick="exportExcel()" class="btn btn-info shadow-sm">
                        <i class="bi bi-file-text me-2"></i>Download CSV
                    </button>
                    <button onclick="exportXLSX()" class="btn btn-success shadow-sm">
                        <i class="bi bi-file-earmark-excel me-2"></i>Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="reportArea">
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Total Pesanan</p>
                                <h3 class="fw-bold mb-0">{{ $orders->count() }}</h3>
                                <small class="text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ $selesai }} Selesai
                                </small>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-cart-check text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Total Item Terjual</p>
                                <h3 class="fw-bold mb-0">{{ number_format($totalItems) }}</h3>
                                <small class="text-muted">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Unit Produk
                                </small>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-boxes text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Total Pendapatan</p>
                                <h3 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </h3>
                                <small class="text-muted">Semua Transaksi</small>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-cash-stack text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Rata-rata Pesanan</p>
                                <h3 class="fw-bold mb-0">
                                    Rp {{ number_format($averageOrder, 0, ',', '.') }}
                                </h3>
                                <small class="text-muted">Per Transaksi</small>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calculator text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Pesanan Selesai</h6>
                                <h4 class="fw-bold mb-0">{{ $selesai }} <small class="text-muted fs-6">pesanan</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-clock-history text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Sedang Diproses</h6>
                                <h4 class="fw-bold mb-0">{{ $diproses }} <small class="text-muted fs-6">pesanan</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-percent text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Tingkat Keberhasilan</h6>
                                <h4 class="fw-bold mb-0">
                                    {{ $orders->count() > 0 ? number_format(($selesai / $orders->count()) * 100, 1) : 0 }}%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-table me-2"></i>Detail Transaksi Penjualan
                            </h5>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                {{ $orders->count() }} Transaksi
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="reportTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="px-4 py-3 text-center" width="60">#</th>
                                        <th class="py-3">Customer</th>
                                        <th class="py-3 text-center">Tanggal</th>
                                        <th class="py-3 text-center">Total Item</th>
                                        <th class="py-3">Total Harga</th>
                                        <th class="py-3 text-center">Status</th>
                                        <th class="py-3 text-center">Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td class="px-4 text-center fw-semibold text-muted">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-fill text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $order->user->name }}</div>
                                                    <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-semibold">{{ $order->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info-subtle text-info px-3 py-2">
                                                {{ $order->items->sum('qty') }} Item
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($order->status == 'selesai')
                                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                                </span>
                                            @elseif($order->status == 'diproses')
                                                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                                    <i class="bi bi-clock-history me-1"></i>Diproses
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                                    <i class="bi bi-hourglass me-1"></i>{{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->payment_method)
                                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                                    <i class="bi bi-credit-card me-1"></i>
                                                    {{ $order->payment_method }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                                    <i class="bi bi-x-circle me-1"></i>Belum Bayar
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                <p class="mb-0">Belum ada data transaksi penjualan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if($orders->count() > 0)
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-end fw-bold">TOTAL:</td>
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-info px-3 py-2">{{ $totalItems }} Item</span>
                                        </td>
                                        <td class="fw-bold text-success fs-5">
                                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: all 0.2s ease;
    }

    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    @media print {
        .btn, .card-header {
            display: none !important;
        }
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Custom scrollbar for table */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

@endsection

{{-- SCRIPT PDF + EXCEL --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

{{-- SheetJS for Excel (.xlsx) --}}
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.getElementById('downloadPDF').addEventListener('click', function () {
    const element = document.getElementById('reportArea');
    html2pdf().set({
        margin: 10,
        filename: 'laporan_penjualan.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    }).from(element).save();
});

function exportExcel() {
    let table = document.getElementById("reportTable");
    let rows = table.querySelectorAll("tr");
    let csvContent = "";
    rows.forEach(row => {
        let cols = row.querySelectorAll("th, td");
        let rowData = [];
        cols.forEach(col => {
            rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
        });
        csvContent += rowData.join(",") + "\n";
    });
    let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    let downloadLink = document.createElement("a");
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = "laporan_penjualan.csv";
    downloadLink.click();
}

function exportXLSX() {
    let table = document.getElementById("reportTable");
    let worksheet = XLSX.utils.table_to_sheet(table);
    let workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Laporan Penjualan");
    XLSX.writeFile(workbook, "laporan_penjualan.xlsx");
}
</script>
@endsection