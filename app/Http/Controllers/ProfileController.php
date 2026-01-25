<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update general profile information (name, email, etc.).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        // If email changed, reset verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update profile avatar and name.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        try {
            // validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:51200', // allow up to 50 MB
            ]);

            $user->name = $validated['name'];

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());

                $destination = public_path('images/avatars');
                if (!is_dir($destination)) mkdir($destination, 0777, true);

                $file->move($destination, $filename);

                $user->avatar = 'images/avatars/' . $filename;
            }


            $user->save();

            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating avatar for user ID {$user->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile.')->withInput();
        }
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

        Auth::logout();

        // Delete avatar file if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            Log::info("Deleted avatar for deleted user ID {$user->id}");
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
