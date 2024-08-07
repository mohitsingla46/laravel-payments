<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $userModel;

    /**
     * @param \App\Models\User $userModel
     *
     * @return void
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param mixed $id
     *
     * @return \App\Models\User|null
     */
    public function getUserById($id)
    {
        return $this->userModel->find($id);
    }

    /**
     * @param integer $id
     * @param array $updatedUser
     *
     * @return void
     */
    public function updateUser($id, $updatedUser)
    {
        $this->userModel->where('id', $id)->update($updatedUser);
    }
}
