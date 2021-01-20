<?php

namespace app\services\stripe;

use app\models\User;
use Stripe\Invoice;
use Yii;

trait TStripeInvoice
{
    /**
     * @param User $user
     * @return \Stripe\Collection
     * @throws \Stripe\Error\Api
     */
    public static function getInvoice(User $user)
    {
        $user = $user ?? Yii::$app->user->identity;

        $invoices = Invoice::all([
            'customer' => $user->stripe_customer_id,
            'limit' => 100,
        ]);

        // hide zero amount invoices
        $invoices->data = array_values(array_filter($invoices->data, function(Invoice $invoice) {
            return $invoice->amount_paid !== 0 || $invoice->total !== 0;
        }));

        return $invoices;
    }

    /**
     * @param string $invoiceId
     * @return bool|Invoice
     */
    public static function finalizeInvoice(string $invoiceId)
    {
        $invoice = Invoice::retrieve($invoiceId);
        if ($invoice->status === Invoice::STATUS_DRAFT) {
            return $invoice->finalizeInvoice();
        } else {
            return false;
        }
    }

    public static function payNow(string $invoiceId)
    {
        $invoice = Invoice::retrieve($invoiceId);

        switch ($invoice->status) {
            case Invoice::STATUS_DRAFT:
                return $invoice->finalizeInvoice();
            case Invoice::STATUS_OPEN:
                return $invoice->pay();
        }

        return false;
    }
}