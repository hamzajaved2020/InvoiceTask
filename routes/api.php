<?php


use App\Http\Controllers\InvoiceController;

Route::group(['prefix' => 'v1'], function () {
    Route::resource('invoices', InvoiceController::class)
        ->only(['index', 'store', 'show']);

});
