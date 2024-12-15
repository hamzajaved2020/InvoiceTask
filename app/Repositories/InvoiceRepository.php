<?php
namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    public function getAll()
    {
        return Invoice::with('users')->get();
    }

    public function create(array $data)
    {
        $invoice = Invoice::create($data);

        if (!empty($data['user_ids'])) {
            $invoice->users()->attach($data['user_ids']);
        }
        return $invoice;
    }
}
