<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return[
            'ID',
            'Nama Kasir',
            'Daftar Obat',
            'Nama Pembeli',
            'Total Harga',
            'Tanggal'

        ];
    }
    public function map($order): array
    {
        $daftarObat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = $key+1 .". ". $value['medicines']. "(". $value['quantity']." pcs)
            Rp.". number_format($value['total_price'], 0, ',', '.').",";
            $daftarObat .= $obat;
        }
        return[
            $order->id,
            $order->user->name,
            $daftarObat,
            $order->name_customer,
            "Rp.". number_format($order->total_price, 0, ',', '.'),
            $order->created_at->isoformat('D MMMM, Y HH:mm:ss')
        ];
    }
}
