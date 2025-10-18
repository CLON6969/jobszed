<?php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
protected $policies = [
    \App\Models\Product::class => \App\Policies\ProductPolicy::class,
    \App\Models\Order::class => \App\Policies\OrderPolicy::class,
    \App\Models\OrderItem::class => \App\Policies\OrderItemPolicy::class,
    \App\Models\Message::class => \App\Policies\MessagePolicy::class,
    \App\Models\Review::class => \App\Policies\ReviewPolicy::class,
    \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
    \App\Models\User::class => \App\Policies\SellerPolicy::class,
    \App\Models\AnalyticsEvent::class => \App\Policies\AnalyticsPolicy::class,
];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
