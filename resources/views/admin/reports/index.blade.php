@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')

@php
    $grandTotal = $orders->sum('total_price');

    $totalItems = 0;
    foreach ($orders as $o) {
        $totalItems += $o->items->sum('qty');
    }
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Laporan Penjualan</h3>

    <div class="d-flex gap-2">
        {{-- Tombol PDF --}}
        <button id="downloadPDF" class="btn btn-danger">
            Download PDF
        </button>

        {{-- Tombol Excel --}}
        <button onclick="exportExcel()" class="btn btn-primary">
            Download CSV
        </button>
        <button onclick="exportXLSX()" class="btn btn-success">
            Download Excel
        </button>

    </div>
</div>

{{-- Semua laporan dibungkus agar bisa di-export --}}
<div id="reportArea">

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Ringkasan Laporan</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <h6 class="text-muted">Total Pesanan</h6>
                        <h4 class="fw-bold">{{ $orders->count() }} pesanan</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <h6 class="text-muted">Total Item Terjual</h6>
                        <h4 class="fw-bold">{{ $totalItems }} item</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <h6 class="text-muted">Total Pendapatan</h6>
                        <h4 class="fw-bold text-success">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0" id="reportTable">
                <thead class="table-dark">
                    <tr>
                        <th width="50px">No</th>
                        <th>Nama Customer</th>
                        <th width="140px">Tanggal Pesanan</th>
                        <th width="130px">Total Item</th>
                        <th>Total Harga</th>
                        <th>Status Pesanan</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="text-center">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="text-center fw-bold">
                            {{ $order->items->sum('qty') }} item
                        </td>
                        <td>
                            <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $order->status == 'selesai' ? 'success' : 
                                ($order->status == 'diproses' ? 'warning' : 'secondary') 
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($order->payment_method)
                                <span class="badge bg-info">{{ $order->payment_method }}</span>
                            @else
                                <span class="badge bg-secondary">Belum Membayar</span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data laporan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div> {{-- end reportArea --}}

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
