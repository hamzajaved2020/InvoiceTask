<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_calculate_total_price_and_events_correctly()
    {
        // Arrange
        $customer = Customer::factory()->create();

        $users = User::factory(1)->create(['customer_id' => $customer->id]);

        $invoiceService = app(InvoiceService::class);

        // Act
        $totalPriceAndEvents = $invoiceService->createInvoice([
                'start_date' => now()->subMonth()->toDateString(),
                'end_date' => now()->toDateString(),
                'customer_id' => $customer->id,
        ]);
        // Assert
        $this->assertEquals(1, $totalPriceAndEvents['total_events']);
    }

    /** @test */
    public function it_fetches_invoice_with_user_details()
    {
        // Arrange
        $invoice = Invoice::factory()->hasUsers(3)->create();

        // Act
        $response = $this->getJson(route('invoices.show', $invoice->id));

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'start_date',
                    'end_date',
                    'customer_id',
                    'total_prices',
                    'total_events',
                    'users' => [
                        '*' => ['id', 'name', 'email', 'created_at'],
                    ],
                ],
            ]);
    }
}
