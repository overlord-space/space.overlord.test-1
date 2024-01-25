<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\UserRepositoryException;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    private static Collection $users;

    /**
     * @throws UserRepositoryException
     */
    public function __construct()
    {
        $this->refreshUsers();
    }

    /**
     * @throws UserRepositoryException
     */
    protected function refreshUsers(): static
    {
        $fileContents = file_get_contents(base_path('users.json'));
        if ($fileContents === false) {
            throw new UserRepositoryException('Failed to read users.json');
        }

        $users = json_decode($fileContents, true);
        if ($users === null) {
            throw new UserRepositoryException('Failed to decode users.json');
        }

        static::$users = collect($users)->mapInto(User::class);

        return $this;
    }

    /**
     * @throws UserRepositoryException
     */
    public function getByEmail(string $email): User
    {
        $user = static::$users->firstWhere('email', $email);

        if ($user === null) {
            throw new UserRepositoryException('User with email ' . $email . ' not found');
        }

        return $user;
    }

    /**
     * @throws UserRepositoryException
     */
    public function getById(int $id): User
    {
        $user = static::$users->firstWhere('id', $id);

        if ($user === null) {
            throw new UserRepositoryException('User with id ' . $id . ' not found');
        }

        return $user;
    }
}
