<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    
    public function editAddress()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.edit-address', compact('user'));
    }
    
    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);
        
        /** @var User $user */
        $user = Auth::user();
        $user->update($request->only('address', 'city', 'postal_code', 'country'));
        
        return redirect()->route('profile')->with('success', 'Alamat berhasil diperbarui!');
    }
}
