<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;
use Carbon\Carbon;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit a message
     */
    public function editMessage(User $user, Message $message)
    {
        $windowMinutes = 15; // edit window
        $withinWindow = Carbon::parse($message->created_at)->addMinutes($windowMinutes)->gt(now());
        return ($user->id === $message->sender_id) && $withinWindow;
    }

    /**
     * Determine if user can leave a review
     */
    public function leaveReview(User $user, Review $review)
    {
        return $user->isCustomer() || is_null($user->id); // allow guest reviews
    }

    /**
     * Determine if customer can view order
     */
    public function viewOrder(User $user, $order)
    {
        return $user->id === $order->buyer_id;
    }
}
