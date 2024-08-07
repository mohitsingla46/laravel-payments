<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    protected $transactionModel;

    /**
     * @param \App\Models\Transaction $transactionModel
     *
     * @return void
     */
    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    /**
     * @param array $transaction
     *
     * @return \App\Models\Transaction
     */
    public function create(array $transaction)
    {
        return $this->transactionModel->create($transaction);
    }

    /**
     * @return array|null
     */
    public function get()
    {
        return $this->transactionModel->with('user')->get()->toArray();
    }
}
