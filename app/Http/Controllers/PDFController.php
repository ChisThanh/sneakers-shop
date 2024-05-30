<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function viewPdfInvoice(string $id)
    {
        $data = Bill::with(['details', 'user'])
            ->find($id);

        // dd($data);
        $pdf = Pdf::loadView('pdf.bill', [
            'data' =>  $data
        ])->setPaper(
            'a4',
            'portrait'
        );

        return $pdf->stream('bill.pdf');
    }

    public function downloadPdfInvoice(string $id)
    {
        $data = Bill::with('details')
            ->find($id);


        $pdf = Pdf::loadView('pdf.bill', [
            'data' =>  $data
        ])->setPaper(
            'a4',
            'portrait'
        );

        return $pdf->download('bill.pdf');
    }
}