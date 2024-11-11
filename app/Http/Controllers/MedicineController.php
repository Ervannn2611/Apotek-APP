<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * R = Read, menampilkan banyak data / halaman utama fitur
     */
    public function index(Request $request) {
        // Mengatur pengurutan berdasarkan stok obat
        $orderStock = $request->sort_stock == 'stock' ? 'ASC' : 'DESC';

        // Mengambil data obat dan mengurutkannya berdasarkan stok
        $medicines = Medicine::orderby('stock', $orderStock)->simplePaginate(5)->appends($request->all());

        // Mengatur pengurutan berdasarkan stok besar/ kecil
        $orderStock = $request->large_stock == 'stock' ? 'DESC' : 'ASC';
        $medicines = Medicine::orderby('stock', $orderStock)->simplePaginate(5)->appends($request->all());

        // Jika ada pencarian, filter data berdasarkan nama obat
        if ($request->has('search')) {
            $medicines = Medicine::where('name', 'LIKE', '%'. $request->search.'%')->orderby('name','ASC')->simplePaginate(5);
        }

        // Mengembalikan view dengan data obat
        return view('medicine.index', compact('medicines'));
    }


    /**
     * C: Create, menampilkan form untuk menambahkan data
     */
    public function create()
    {
        // Mengembalikan view untuk form input obat baru
        return view('medicine.create');
    }

    /**
     * C: Create, menambahkan data ke database
     */
    public function store(Request $request)
    {

        // Validasi input dari form
        $request->validate([
            'name' => 'required|max:100',    // Nama harus diisi dan maksimal 100 karakter
            'type' => 'required|min:3',       // Jenis obat harus diisi dan minimal 3 karakter
            'price' => 'required|numeric',    // Harga harus diisi dan harus numerik
            'stock' => 'required|numeric',    // Stok harus diisi dan harus numerik
        ], [
            // Pesan kesalahan validasi
            'name.required' => 'Nama harus diisi',
            'type.required' => 'Jenis obat harus diisi',
            'price.required' => 'Harga harus diisi',
            'stock.required' => 'Stok harus diisi',
            'name.max' => 'Maksimal 100 karakter',
            'type.min' => 'Minimal 3 karakter',
            'price.numeric' => 'Harga harus numerik',
            'stock.numeric' => 'Stok harus numerik',
        ]);

        try {
            // Menyimpan data obat baru ke database
            Medicine::create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);

            // Mengalihkan kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Data gagal ditambahkan!')->withInput();
        }
    }

    /**
     * R = Read, menampilkan data spesifik (data hanya 1)
     */
    public function show(string $id)
    {
        // Belum diimplementasikan, seharusnya mengembalikan detail obat berdasarkan ID
    }

    /**
     * U = Update, untuk menampilkan form untuk mengedit data
     */
    public function edit(string $id)
    {
        // Mengambil data obat berdasarkan ID untuk diedit
        $data = Medicine::find($id);

        // Mengembalikan view untuk form edit obat
        return view('medicine.edit', [
            'item' => $data
        ]);
    }

    /**
     * U = Update, mengupdate data ke database / eksekusi edit
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari form edit
        $data = $request->validate([
            'name' => 'required|max:100',    // Nama harus diisi dan maksimal 100 karakter
            'type' => 'required|min:3',       // Jenis obat harus diisi dan minimal 3 karakter
            'price' => 'required|numeric',    // Harga harus diisi dan harus numerik
        ], [
            // Pesan kesalahan validasi
            'name.required' => 'Nama harus diisi',
            'type.required' => 'Jenis obat harus diisi',
            'price.required' => 'Harga harus diisi',
            'name.max' => 'Maksimal 100 karakter',
            'type.min' => 'Minimal 3 karakter',
            'price.numeric' => 'Harga harus numerik',
        ]);

        // Mengupdate data obat berdasarkan ID
        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        // Mengalihkan ke route yang ditentukan dengan pesan sukses
        return redirect()->route('obat.data')->with('success', 'Data berhasil Diubah!');
    }

    /**
     * Mengupdate stok obat
     */
    public function updateStock(Request $request, $id) {
        // Mengecek jika stok tidak diisi
        if (isset($request->stock) == FALSE) {
            // Mengambil data sebelumnya untuk ditampilkan jika terjadi kesalahan
            $dataSebelumnya = Medicine::where('id', $id)->first();

            // Mengalihkan kembali dengan pesan kesalahan
            return redirect()->back()->with([
                'failed' => 'Stock tidak Boleh kosong !',
                'id' => $id,
                'stock' => $dataSebelumnya->stock,
            ]);
        }

        // Mengupdate stok obat berdasarkan ID
        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        // Mengalihkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil Mengupdate Stock obat');
    }

    /**
     * D = Delete, menghapus data dari database
     */
    public function destroy(string $id)
    {
        // Mencari data obat berdasarkan ID
        $deletedata = Medicine::find($id);

        // Jika data ditemukan dan berhasil dihapus
        if ($deletedata && $deletedata->delete()) {
            return redirect()->back()->with('success', 'Berhasil Menghapus Data!');
        } else {
            // Jika gagal menghapus data
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
