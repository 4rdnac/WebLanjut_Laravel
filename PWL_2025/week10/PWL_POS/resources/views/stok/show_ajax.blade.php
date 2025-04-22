<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Stok Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $stok->barang->barang_kode ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $stok->stok_jumlah }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>{{ \Carbon\Carbon::parse($stok->stok_tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $stok->stok_tanggal }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $stok->updated_at }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>