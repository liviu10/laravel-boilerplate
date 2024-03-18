<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteNewUser;
use App\Mail\WelcomeNewUser;
use App\Mail\ProfileUpdated;
use Illuminate\Support\Facades\Route;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $currentRouteName = Route::current()->getName();
        if ($currentRouteName === 'users.store') {
            Mail::to($user->getAttributes()['email'])->send(new InviteNewUser($user->getAttributes()));
        }

        Mail::to($user->getAttributes()['email'])->send(new WelcomeNewUser($user->getAttributes()));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Mail::to($user->getAttributes()['email'])->send(new ProfileUpdated($user->getAttributes()));
    }
}
