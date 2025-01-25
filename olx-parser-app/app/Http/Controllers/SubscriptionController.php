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

        return response()->json(['message' => 'Subscription successful!','success' => true], 201);
    }

    public function checkSubscription(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'email' => 'required|email',
            'url_link' => 'required|url',
        ]);

        // Find the user by email
        $user = User::where('email', $validated['email'])->first();

        // If user doesn't exist, return false
        if (!$user) {
            return response()->json(['exists' => false]);
        }

        // Check if the subscription exists
        $subscriptionExists = $user->links()->where('url_link', $validated['url_link'])->exists();

        return response()->json(['exists' => $subscriptionExists]);
    }

    public function deleteSubscription(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'email' => 'required|email',
            'url_link' => 'required|url',
        ]);

        // Find the user by email
        $user = User::where('email', $validated['email'])->first();

        // If user doesn't exist, return an error
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the subscription exists
        $link = Link::where('url_link', $validated['url_link'])->first();

        if (!$link) {
            return response()->json(['message' => 'Subscription not found.'], 404);
        }

        // Detach the relationship between user and link
        $user->links()->detach($link->id);

        return response()->json(['message' => 'Subscription deleted successfully.', 'success' => true], 200);
    }
}