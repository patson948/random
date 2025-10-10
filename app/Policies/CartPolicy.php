<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function update(?User $user, Cart $cart): bool
    {
        if ($user) {
            return $cart->user_id === $user->id;
        }

        return $cart->session_id === session()->getId();
    }

    public function delete(?User $user, Cart $cart): bool
    {
        if ($user) {
            return $cart->user_id === $user->id;
        }

        return $cart->session_id === session()->getId();
    }
}


