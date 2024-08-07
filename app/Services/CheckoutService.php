<?php

namespace App\Services;

class CheckoutService
{
    /**
     * @return (int|string)[]
     */
    public function getDetails()
    {
        //static data for payment
        return [
            'amount' => 1,
            'currency' => 'usd',
            'display_currency' => '$'
        ];
    }
}
