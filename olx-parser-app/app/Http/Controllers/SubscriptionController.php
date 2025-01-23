<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;

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

        // Check if a subscription already exists for this user and URL
        $existingLink = Link::where('user_id', $user->id)
                            ->where('url_link', $validated['url_link'])
                            ->first();

        if ($existingLink) {
            return response()->json(['message' => 'You are already subscribed to this listing.'], 200);
        }

        // Create a new subscription (link)
        $link = Link::create([
            'user_id' => $user->id,
            'url_link' => $validated['url_link'],
            'last_price' => null, // Initially, no price is tracked
        ]);

        return response()->json(['message' => 'Subscription successful!'], 201);
    }
}