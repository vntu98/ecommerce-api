<?php

namespace App\Http\Controllers\PaymentMethods;

use App\Cart\Payments\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function index()
    {
        return PaymentMethodResource::collection(request()->user()->paymentMethods);
    }

    public function store(Request $request)
    {
        $card = $this->gateway->withUser($request->user())
            ->createCustomer()
            ->addCard($request->token);
    }
}
