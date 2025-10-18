<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 3, 4]);
    }

    public function view(User $user, Message $message): bool
    {
        return $user->isAdmin()
            || $message->sender_id === $user->id
            || $message->receiver_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isSeller();
    }

    public function update(User $user, Message $message): bool
    {
        return $user->isAdmin() || $message->sender_id === $user->id;
    }

    public function delete(User $user, Message $message): bool
    {
        return $user->isAdmin() || $message->sender_id === $user->id;
    }
}
