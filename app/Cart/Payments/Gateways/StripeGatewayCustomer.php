<?php

namespace App\Cart\Payments\Gateways;

use App\Cart\Payments\Gateway;
use App\Cart\Payments\GatewayCustomer;
use App\Models\PaymentMethod;
use App\Models\User;

class StripeGatewayCustomer implements GatewayCustomer
{
    public function charge(PaymentMethod $card, $amount)
    {
        
    }

    public function addCard($token)
    {
        
    }
}