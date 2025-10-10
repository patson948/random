<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            return $this->handleSocialCallback($googleUser, 'google');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            
            return $this->handleSocialCallback($facebookUser, 'facebook');
        } catch (\Exception $e) {
            \Log::error('Facebook OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Facebook authentication failed. Please try again.');
        }
    }

    /**
     * Redirect to GitHub OAuth
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle GitHub OAuth callback
     */
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            return $this->handleSocialCallback($githubUser, 'github');
        } catch (\Exception $e) {
            \Log::error('GitHub OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'GitHub authentication failed. Please try again.');
        }
    }

    /**
     * Handle social authentication callback
     */
    private function handleSocialCallback($socialUser, $provider)
    {
        try {
            // Check if user already exists with this social ID
            $existingUser = User::where($provider . '_id', $socialUser->getId())->first();

            if ($existingUser) {
                // User exists, log them in
                Auth::login($existingUser);
                return $this->redirectAfterLogin();
            }

            // Check if user exists with the same email
            $userByEmail = User::where('email', $socialUser->getEmail())->first();

            if ($userByEmail) {
                // User exists with same email, link the social account
                $userByEmail->update([
                    $provider . '_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'provider' => $provider,
                ]);

                Auth::login($userByEmail);
                return $this->redirectAfterLogin();
            }

            // Create new user
            $newUser = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(24)), // Random password
                'role' => 'customer', // Default role
                'is_active' => true,
                $provider . '_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
                'email_verified_at' => now(), // Social accounts are considered verified
            ]);

            Auth::login($newUser);
            return $this->redirectAfterLogin();

        } catch (\Exception $e) {
            \Log::error('Social Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Redirect user after successful login
     */
    private function redirectAfterLogin()
    {
        $user = Auth::user();
        
        // Check if user has a vendor account
        if ($user->vendor) {
            if (!$user->vendor->is_approved) {
                return redirect()->route('vendor.pending');
            }
            return redirect()->route('vendor.dashboard');
        }

        // Check user role and redirect accordingly
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'vendor':
                return redirect()->route('vendor.dashboard');
            default:
                return redirect()->route('home');
        }
    }
}