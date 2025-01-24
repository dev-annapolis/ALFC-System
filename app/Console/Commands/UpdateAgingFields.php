<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\ArAging;
use Carbon\Carbon;
class UpdateAgingFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:aging';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $arAgings = ArAging::with('arAgingPivots')->get();

        foreach ($arAgings as $aging) {
            $currentDate = Carbon::now();
            $unpaidCount = 0;
            $agingDueDays = null;
            $agingDescription = null;


            $pivots = $aging->arAgingPivots->sortBy('payment_date');


            $failedpayments = [];
            $failedtopay = false;
            foreach ($pivots as $pivot) {
                $paymentDate = Carbon::parse($pivot->payment_schedule);
                if (!$pivot->paid && $paymentDate->lessThanOrEqualTo($currentDate)) {
                    $unpaidCount++;
                    // Log::info("Unpaid count: " . $unpaidCount . " for payment date: " . $pivot->payment_schedule);
                    if (!$failedtopay) {
                        $lastPaymentSched = $paymentDate;
                        $failedtopay = true;
                    }
                    $failedpayments[] = $pivot->payment_schedule; // Add payment_schedule to the array
                }
            }

            $aging->aging_due_days = "Due Days: " . floor(abs($lastPaymentSched->diffInDays($currentDate)));
            // Log the aging_due_days to ensure it is rounded down
            Log::info("Aging Due Days: " . $aging->aging_due_days);
            // Log unpaid count for debugging
            // Log::info("ArAging ID {$aging->id} - Unpaid Count: {$unpaidCount}, Last Paid Date: {$aging->last_paid_date}");

            // Implement your logic for aging description
            if ($unpaidCount === 1) {
                // Format the first failed payment date
                $formattedDate = Carbon::parse($failedpayments[0])->format('M j, Y'); // Jan 1, 2024
                // Insert a line break using <br> instead of \n
                $agingDescription = "{$formattedDate} <br> payment not made";  // Use the formatted date and add a line break
            } elseif ($unpaidCount >= 2) {
                $agingDescription = "{$unpaidCount} payments not made,<br> subject for cancellation";
            } else {
                $agingDescription = 'Up to Date';
            }

            $aging->aging_description = $agingDescription;

            // Save updated record
            $aging->save();
        }

        $this->info('Aging updated successfully!');
        Log::info('Aging updated successfully!');
    }






}
