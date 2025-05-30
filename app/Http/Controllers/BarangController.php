<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = \App\Models\Barang::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('deskripsi', 'like', "%$search%");
        }

        $barangs = $query->latest()->paginate(10);
        return view('barangs.index', compact('barangs'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barangs.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        \App\Models\Barang::create($request->all());

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        return view('barangs.edit', compact('barang'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $barang = \App\Models\Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus');
    }

   public function exportPdf(Request $request)
    {
        $query = \App\Models\Barang::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('deskripsi', 'like', "%$search%");
        }

        $barangs = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('barangs.pdf', compact('barangs'));
        return $pdf->download('daftar-barang.pdf');
    }


}
