<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class AdminSettingsController extends Controller
{
    /**
     * Show admin settings (profile + password)
     */
    public function edit()
    {
        $user = Auth::user();
        // If the request is an Inertia visit, return an Inertia page so SPA navigation works
        if (request()->header('X-Inertia')) {
            return Inertia::render('Admin/CaiDat/Index', ['user' => $user]);
        }

        return view('admin.settings', ['user' => $user]);
    }

    /**
     * Update profile info (name, email, mobile)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        // Validate basic profile fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:30',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Some schemas may not have `mobile` column — update only if present
        if (Schema::hasColumn('users', 'mobile')) {
            $user->mobile = $validated['mobile'] ?? $user->mobile;
        }

        $passwordChanged = false;

        // If password fields were submitted, validate and update password as well
        if ($request->filled('old_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
            $pwValidated = $request->validate([
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            if (! 
                \Illuminate\Support\Facades\Hash::check($pwValidated['old_password'], $user->password)
            ) {
                return redirect()->route('admin.settings')->withErrors(['old_password' => 'Mật khẩu cũ không đúng.'])->withInput();
            }

            $user->password = \Illuminate\Support\Facades\Hash::make($pwValidated['new_password']);
            $passwordChanged = true;
            Log::info('Admin changed password via settings form', ['user_id' => $user->id]);
        }

        $user->save();

        $message = $passwordChanged ? 'Cập nhật thông tin và mật khẩu thành công.' : 'Cập nhật thông tin thành công.';

        return redirect()->route('admin.settings')->with('success', $message);
    }

    /**
     * Change password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($validated['old_password'], $user->password)) {
            return redirect()->route('admin.settings')->withErrors(['old_password' => 'Mật khẩu cũ không đúng.']);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        Log::info('Admin changed password', ['user_id' => $user->id]);

        return redirect()->route('admin.settings')->with('success', 'Đổi mật khẩu thành công.');
    }
}
