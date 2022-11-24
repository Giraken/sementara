<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Response;

class InvoiceController extends Controller
{
    public function download(Request $request)
    {
        $invoice = Invoice::findByUid($request->uid);

        return Response::make($invoice->exportToPdf(), 200, [
            'Content-type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->uid . '.pdf"',
        ]);
    }
}
