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

        if (auth()->user()->checkAdmin()) {
            $data = Bill::with(['details', 'user'])
                ->find($id);
        } else {
            $data = Bill::with(['details', 'user'])
                ->where('user_id', auth()->id())
                ->find($id);
        }

        if (!$data) {
            return response()->json(['error' => 'Bill not found'], 404);
        }

        $user = auth()->user();

        $pdf = Pdf::loadView('pdf.bill', [
            'data' =>  $data,
            'user' =>  $user
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('bill.pdf');
    }

    public function downloadPdfInvoice(string $id)
    {
        if (auth()->user()->checkAdmin()) {
            $data = Bill::with(['details', 'user'])
                ->find($id);
        } else {
            $data = Bill::with(['details', 'user'])
                ->where('user_id', auth()->id())
                ->find($id);
        }

        if (!$data) {
            return response()->json(['error' => 'Bill not found'], 404);
        }

        $user = auth()->user();

        $pdf = Pdf::loadView('pdf.bill', [
            'data' =>  $data,
            'user' =>  $user
        ])->setPaper(
            'a4',
            'portrait'
        );

        return $pdf->download('bill.pdf');
    }
}