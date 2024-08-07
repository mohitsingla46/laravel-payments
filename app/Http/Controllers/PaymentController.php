<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Services\StripeService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $stripeService;
    protected $transactionService;
    protected $checkoutService;

    /**
     * @param \App\Services\StripeService $stripeService
     * @param \App\Services\TransactionService $transactionService
     * @param \App\Services\CheckoutService $checkoutService
     *
     * @return void
     */
    public function __construct(
        StripeService $stripeService,
        TransactionService $transactionService,
        CheckoutService $checkoutService
        )
    {
        $this->stripeService      = $stripeService;
        $this->transactionService = $transactionService;
        $this->checkoutService = $checkoutService;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $cards        = $this->stripeService->card_list();
        $transactions = $this->transactionService->get();
        $payment      = $this->checkoutService->getDetails();
        return view('payment', compact('cards', 'transactions', 'payment'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add_card()
    {
        return view('add_card');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_card(Request $request)
    {
        return $this->stripeService->save_card($request->token);
    }

    /**
     * @param string $card_id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete_card($card_id)
    {
        $this->stripeService->delete_card($card_id);
        return redirect('/');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function doPayment(Request $request)
    {
        $this->stripeService->createPayment($request->all());
        return redirect('/');
    }
}
