<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService
{
    protected $transactionRepository;

    /**
     * @param \App\Repositories\TransactionRepository $transactionRepository
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param array $transaction
     *
     * @return \App\Models\Transaction|null
     */
    public function create($transaction)
    {
        return $this->transactionRepository->create($transaction);
    }

    /**
     * @return array|null
     */
    public function get()
    {
        return $this->transactionRepository->get();
    }
}
