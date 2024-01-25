<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdvertisementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, Advertisement $advertisement): Response
    {
        if ($advertisement->active === false) {
            return $this->denyWithStatus(403, 'This advertisement is not active.');
        }

        return $this->allow();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function activate(User $user, Advertisement $advertisement): Response
    {
        return $this->checkAdvertisementOwnership($user, $advertisement);
    }

    public function update(User $user, Advertisement $advertisement): Response
    {
        return $this->checkAdvertisementOwnership($user, $advertisement);
    }

    public function delete(User $user, Advertisement $advertisement): Response
    {
        return $this->checkAdvertisementOwnership($user, $advertisement);
    }

    protected function checkAdvertisementOwnership(User $user, Advertisement $advertisement): Response
    {
        if ($user->id === $advertisement->user_id) {
            return $this->allow();
        }

        return $this->denyWithStatus(403, 'You are not the owner of this advertisement.');
    }

    public function restore(User $user, Advertisement $advertisement): Response
    {
        return $this->deny('Action not allowed.');
    }

    public function forceDelete(User $user, Advertisement $advertisement): Response
    {
        return $this->deny('Action not allowed.');
    }
}
