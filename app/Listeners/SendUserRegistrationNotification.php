<?php

namespace App\Listeners;

use App\Events\UserRegistred;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Tag;

class SendUserRegistrationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistred $event): void
    {
        $user = User::find($event->userId);
        
        $tag = new Tag;
        $tag->user_id= $user->id;
        $tag->name = "ppp5";
        $tag->is_active= 1;
        $tag->created_by= $user->id;
        $tag->updated_by= $user->id;
        $tag->save();
    }
}
