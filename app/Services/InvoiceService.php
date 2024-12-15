<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Session;
use App\Models\User;
use App\Repositories\InvoiceRepository;

class InvoiceService
{
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function getAllInvoices()
    {
        return $this->invoiceRepository->getAll();
    }

    public function createInvoice(array $data)
    {
        $calculation = $this->calculateTotalPriceAndEvents(
            $data['start_date'],
            $data['end_date'],
            $data['customer_id']
        );

        $data['total_prices'] = $calculation['total_price'];
        $data['total_events'] = $calculation['event_count'];
        $data['user_ids'] = $calculation['user_ids'];

        return $this->invoiceRepository->create($data);
    }

    public function calculateTotalPriceAndEvents($startDate, $endDate, $customerId)
    {
        $users = User::where('customer_id', $customerId)->get();
        $totalPrice = 0;
        $eventCount = 0;
        $userIds = [];

        // Fetch previous invoices with user data to avoid N+1 queries
        $previousInvoices = Invoice::where('customer_id', $customerId)
            ->with('users')
            ->get();

        // Fetch for activations in the period with users to avoid N+1 queries
        $sessions = Session::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        foreach ($users as $user) {
            $userPrice = 0;
            $userEventCount = 0;
            // Check prior invoices for the current user
            $previousTotal = $previousInvoices->filter(function ($invoice) use ($user) {
                return $invoice->users->contains('id', $user->id);
            })->sum('total_prices');

            // Calculate registration fee (if registration is before period)
            if ($user->created_at < $startDate) {
                $userPrice += 50; // Registration fee
                $userEventCount += 1;
            }

            // Check for activations in the period
            $activations = $sessions->where('user_id', $user->id)
                ->whereNotNull('activated')->count();

            if ($activations > 0) {
                $userPrice = max($userPrice, 100); // Activation fee (higher priority)
                $userEventCount += $activations;
            }

            // Check for appointments in the period
            $appointments = $sessions->where('user_id', $user->id)
                ->whereNotNull('appointment')->count();

            if ($appointments > 0) {
                $userPrice = max($userPrice, 200); // Appointment fee (highest priority)
                $userEventCount += $appointments;
            }

            // Subtract previously invoiced amounts
            $adjustedPrice = max(0, $userPrice - $previousTotal);

            if ($adjustedPrice > 0) {
                $totalPrice += $adjustedPrice;
                $eventCount += $userEventCount;
                $userIds[] = $user->id;
            }
        }

        return [
            'total_price' => $totalPrice,
            'event_count' => $eventCount,
            'user_ids' => $userIds,
        ];
    }


}
