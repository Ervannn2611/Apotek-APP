<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportExcel() {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }


    public function index(Request $request)
    {
        //

        $orders = Order::where('user_id', Auth::user()->id)->where('created_at', 'like', '%'.$request->search.'%')->simplePaginate(5);
        $orders->appends(['search' => $request->search]);

        return view('order.kasir.kasir', compact('orders'));
    }
    public function indexAdmin(Request $request) {

        $orders = Order::with('user')->where('created_at', 'like', '%'.$request->search.'%')->simplePaginate(5);
        $orders->appends(['search' => $request->search]);

        return view('order.admin.data', compact('orders'));
    }


    public function downloadPDF($id) {
        $order = Order::where('id', $id)->first()->toArray();

        view()->share('order', $order);
        $pdf = PDF::loadview('order.kasir.pdf', $order);
        return $pdf->download('struk-pembelian.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.form', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "",
            "medicines" => "required",
        ]);

        //mencari values array yang datanya sama
        $arrayValues = array_count_values($request->medicines);
        $arrayNewMedicines = [];

        foreach ($arrayValues as $key => $value) {
            $medicine = Medicine::where('id', $key)->first();

            if($medicine['stock'] < $value) {
                $valueBefore = [
                    "name" => $request->name,
                    "medicines" => $request->medicines
                ];
                $msg = 'Stock Obat' . $medicine ['name'] . 'Tidak Cukup';
                return redirect()->back()->withInput()->with
                ([ 'failed' => $msg, "valuesBefore" => $arrayValues]);
            } else {
                $medicine['stock'] -= $value;
                $medicine->save();
            }
            $totalPrice = $medicine['price'] * $value;

            $arrayItem = [
                "id" => $key,
                "medicines" => $medicine ['name'],
                "price" => $medicine ['price'],
                "quantity" => $value,
                "total_price" => $totalPrice,
            ];

            array_push($arrayNewMedicines, $arrayItem);
        }

        $total = 0;
        foreach($arrayNewMedicines as $item) {
            $total += $item['total_price'];
        }

        $ppn = $total + ($total * 0.1);

        $orders = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $ppn,
        ]);

        if ($orders) {
            $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('pembelian.print', $result->id)->with('success', "Berhasil Order");
        } else {
            return redirect()->back()->with('failed', "Gagal Order");
        }

    }


    /**
     * Display the specified resource.
     */
    /**
 * Display the specified resource.
 */
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('pembelian.index')->with('failed', 'Order not found.');
        }

        return view('order.kasir.print', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
