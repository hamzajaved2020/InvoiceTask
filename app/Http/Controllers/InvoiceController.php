<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    // GET: Retrieve all invoices
    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return response()->json(InvoiceResource::collection($invoices));
    }

    // GET: Retrieve a single invoice with user details
    public function show($id)
    {
        $invoice = Invoice::with('users')->findOrFail($id);
        return new InvoiceResource($invoice);
    }

    // POST: Create a new invoice
    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();

        $invoice = $this->invoiceService->createInvoice($validated);

        return response()->json(new InvoiceResource($invoice));
    }
}
