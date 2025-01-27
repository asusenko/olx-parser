<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'email' => 'required|email',
            'url_link' => 'required|url',
        ]);

        // Check if the user exists or create a new one
        $user = User::firstOrCreate(['email' => $validated['email']]);

        // Check if the link already exists in the links table
        $link = Link::firstOrCreate(
            ['url_link' => $validated['url_link']],
            ['last_price' => null] // Set initial price to null
        );

        // Attach the link to the user if not already subscribed
        if ($user->links()->where('link_id', $link->id)->exists()) {
            return response()->json(['message' => 'You are already subscribed to this listing.'], 200);
        }

        $user->links()->attach($link->id);

        return response()->json(['message' => 'Subscription successful!'], 201);
    }
}