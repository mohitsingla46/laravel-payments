<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $user_id;
    protected $userRepository;

    /**
     * @param \App\Repositories\UserRepository $userRepository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user_id = 1;
    }

    /**
     * @param integer $id
     *
     * @return \App\Models\User|null
     */
    public function getUser()
    {
        return $this->userRepository->getUserById($this->user_id);
    }

    /**
     * @param array $updateUser
     *
     * @return void
     */
    public function updateUser($updateUser)
    {
        $this->userRepository->updateUser($this->user_id, $updateUser);
    }
}
