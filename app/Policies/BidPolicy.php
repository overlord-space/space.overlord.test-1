<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Bid;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BidPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->deny('Action not allowed.');
    }

    public function view(User $user, Bid $bid): Response
    {
        return $this->checkBidOwnership($user, $bid);
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, Bid $bid): Response
    {
        return $this->checkBidOwnership($user, $bid);
    }

    public function delete(User $user, Bid $bid): Response
    {
        return $this->checkBidOwnership($user, $bid);
    }

    protected function checkBidOwnership(User $user, Bid $bid): Response
    {
        if ($user->id === $bid->user_id) {
            return $this->allow();
        }

        return $this->denyWithStatus(403, 'You are not the owner of this bid.');
    }

    public function restore(User $user, Bid $bid): Response
    {
        return $this->deny('Action not allowed.');
    }

    public function forceDelete(User $user, Bid $bid): Response
    {
        return $this->deny('Action not allowed.');
    }
}
