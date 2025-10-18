<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
public function edit(Request $request): View
{
    $user = $request->user();

    // Define the fields you want to consider for profile completion
    $profileFields = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'bio',
        'profile_picture',
    ];

    // Count how many fields are filled
    $filledCount = collect($profileFields)->reduce(function ($count, $field) use ($user) {
        return $count + (!empty($user->$field) ? 1 : 0);
    }, 0);

    // Calculate completion percentage
    $profileCompletion = round(($filledCount / count($profileFields)) * 100);

    return view('Seller.profile-account.index', [
        'user' => $user,
        'profileCompletion' => $profileCompletion, // pass to Blade
    ]);
}


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $validated['profile_picture'] = $request->file('profile_picture')->store(
                'profile_pictures/' . $user->id,
                'public'
            );
        }

        $user->fill($validated);

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('Seller.profile-account.index')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile picture securely
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        Auth::logout();

        // Optionally, delete sub-accounts if needed
        if (method_exists($user, 'subAccounts') && $user->subAccounts()->exists()) {
            $user->subAccounts()->each(fn($sub) => $sub->delete());
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
