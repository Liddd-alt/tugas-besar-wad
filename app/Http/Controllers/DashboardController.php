<?php

namespace App\Http\Controllers;

use App\Models\Found;
use App\Models\Lost;
use App\Models\Matching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'total_lost_items' => 0,
            'total_found_items' => 0,
            'total_users' => 0,
            'total_matches' => 0,
            'latest_lost_items' => collect(),
            'latest_found_items' => collect(),
            'recent_matches' => collect(),
        ];

        if ($user->role === 'admin') {
            $data['total_lost_items'] = Lost::count();
            $data['total_found_items'] = Found::count();
            $data['total_users'] = User::where('role', 'user')->count();
            $data['total_matches'] = Matching::count();
            
            // Get all items with pagination for admin
            $data['latest_lost_items'] = Lost::with(['category', 'user'])
                ->latest()
                ->paginate(10, ['*'], 'lost_page');
                
            $data['latest_found_items'] = Found::with(['category', 'user'])
                ->latest()
                ->paginate(10, ['*'], 'found_page');
                
            $data['recent_matches'] = Matching::with(['lostItem', 'foundItem', 'admin'])
                ->latest()
                ->paginate(10, ['*'], 'matches_page');
        } else {
            $data['total_lost_items'] = Lost::where('user_id', $user->id)->count();
            $data['total_found_items'] = Found::where('user_id', $user->id)->count();
            $data['total_matches'] = Matching::whereHas('lostItem', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->orWhereHas('foundItem', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();
            
            // Get all items with pagination for user
            $data['latest_lost_items'] = Lost::with(['category', 'user'])
                ->latest()
                ->paginate(10, ['*'], 'lost_page');
                
            $data['latest_found_items'] = Found::with(['category', 'user'])
                ->latest()
                ->paginate(10, ['*'], 'found_page');
                
            $data['recent_matches'] = Matching::with(['lostItem', 'foundItem', 'admin'])
                ->whereHas('lostItem', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->orWhereHas('foundItem', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(10, ['*'], 'matches_page');
        }

        return view('dashboard', $data);
    }
}