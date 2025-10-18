<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization;

    public function manageProfile(User $user)
    {
        return $user->isSeller();
    }

    public function manageProduct(User $user, Product $product)
    {
        return $user->id === $product->seller_id;
    }

    public function manageOrder(User $user, Order $order)
    {
        return $user->id === $order->seller_id;
    }

    public function manageMessage(User $user, Message $message)
    {
        return $user->id === $message->receiver_id;
    }
}
