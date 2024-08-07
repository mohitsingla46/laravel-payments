<?php

namespace App\Repositories;

class StripeRepository
{
    protected $stripe;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    }

    /**
     * @param string $name
     * @param string $email
     *
     * @return \Stripe\Customer
     */
    public function createCustomer($name, $email)
    {
        return $this->stripe->customers->create([
            'name' => $name,
            'email' => $email,
        ]);
    }

    /**
     * @param string $user_stripe_id
     *
     * @return \Stripe\Customer
     */
    public function getCustomer($user_stripe_id)
    {
        return $this->stripe->customers->retrieve($user_stripe_id, []);
    }

    /**
     * @param string $customer_id
     * @param string $token
     *
     * @return \Stripe\Account|\Stripe\BankAccount|\Stripe\Card|\Stripe\Source
     */
    public function createSource($customer_id, $token)
    {
        return $this->stripe->customers->createSource($customer_id, ['source' => $token]);
    }

    /**
     * @param string $user_stripe_id
     *
     * @return \Stripe\Collection<\Stripe\PaymentMethod>
     */
    public function payment_methods($user_stripe_id)
    {
        return $this->stripe->paymentMethods->all([
            'customer' => $user_stripe_id,
            'type'     => 'card',
        ]);
    }

    /**
     * @param string $customer_id
     * @param string $card_id
     *
     * @return void
     */
    public function deleteSource($customer_id, $card_id){
        $this->stripe->customers->deleteSource(
            $customer_id,
            $card_id,
            []
        );
    }

    /**
     * @param array $data
     *
     * @return \Stripe\PaymentIntent
     */
    public function createPayment($data)
    {
        return $this->stripe->paymentIntents->create($data);
    }
}
