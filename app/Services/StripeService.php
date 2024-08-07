<?php

namespace App\Services;

use App\Repositories\StripeRepository;
use Exception;

class StripeService
{
    protected $stripeRepository;
    protected $userService;
    protected $transactionService;

    /**
     * @param \App\Repositories\StripeRepository $stripeRepository
     * @param \App\Services\UserService $userService
     * @param \App\Services\TransactionService $transactionService
     *
     * @return void
     */
    public function __construct(
        StripeRepository $stripeRepository,
        UserService $userService,
        TransactionService $transactionService
        )
    {
        $this->stripeRepository   = $stripeRepository;
        $this->userService        = $userService;
        $this->transactionService = $transactionService;
    }

    /**
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_card($token)
    {
        try {
            $user = $this->userService->getUser();
            if ($user->stripe_id) {
                $customer = $this->stripeRepository->getCustomer($user->stripe_id);
            } else {
                $customer = $this->stripeRepository->createCustomer($user->name, $user->email);
                $this->userService->updateUser(['stripe_id' => $customer->id]);
            }

            $this->stripeRepository->createSource($customer->id, $token);
            return response()->json(['success' => true, 'customer' => $customer]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @return array
     */
    public function card_list()
    {
        $payment_methods = [];

        $user = $this->userService->getUser();
        if ($user->stripe_id) {
            $payment_methods = $this->stripeRepository->payment_methods($user->stripe_id);
            $payment_methods = (count($payment_methods['data'])) ? $payment_methods['data'] : [];
        }

        return $payment_methods;
    }

    /**
     * @param string $card_id
     *
     * @return void
     */
    public function delete_card($card_id)
    {
        $user = $this->userService->getUser();
        if ($user->stripe_id) {
            $this->stripeRepository->deleteSource($user->stripe_id, $card_id);
        }
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function createPayment($data)
    {
        $user = $this->userService->getUser();
        if ($user->stripe_id) {
            $result = $this->stripeRepository->createPayment([
                'amount' => $data['amount'] * 100,
                'currency' => $data['currency'],
                'payment_method' => $data['card'],
                'customer' => $user->stripe_id,
                'confirm' => true,
                'return_url' => url('/')
            ]);

            if ($result) {
                $this->transactionService->create([
                    'user_id'               => $user->id,
                    'stripe_transaction_id' => $result->id,
                    'currency'              => $result->currency,
                    'amount'                => $result->amount_received,
                    'status'                => ($result->status == 'succeeded') ? 1 : 0,
                ]);
            }
        }
    }
}
