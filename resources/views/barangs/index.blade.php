<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-primary">
            Manajemen Barang
        </h2>
    </x-slot>

        <!-- tambah barang -->
    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
        <div class="btn-group">
            <a href="{{ route('barangs.create') }}" class="btn btn-primary">
                + Tambah Barang
            </a>
            <!-- pdf -->
            <a href="{{ route('barangs.export.pdf', ['search' => request('search')]) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
            </a>
        </div>

            <!-- search -->
            <form method="GET" action="{{ route('barangs.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari barang...">
                <button class="btn btn-outline-secondary">Cari</button>
            </form>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-nowrap">🛒 Nama</th>
                        <th class="text-nowrap">📝 Deskripsi</th>
                        <th class="text-nowrap">📦 Stok</th>
                        <th class="text-nowrap">💰 Harga</th>
                        <th class="text-nowrap">⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                        <tr>
                            <td class="fw-semibold">{{ ucfirst($barang->nama) }}</td>
                            <td>{{ $barang->deskripsi }}</td>
                            <td class="text-center">{{ $barang->stok }}</td>
                            <td class="text-end">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data barang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $barangs->withQueryString()->links() }}
    </div>
</x-app-layout>
