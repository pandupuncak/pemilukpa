<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\MyHelper;

class HomeController extends Controller
{
    public function show() {
        // Render dashboard based on user vote status
        $user = Auth::user();

        return MyHelper::renderWithRole('Dashboard', [
            'voteStatus' => $user->vote_status,
            'isBeforeVotingPeriod' => MyHelper::isBeforeVotingPeriod(),
            'isAfterVotingPeriod' => MyHelper::isAfterVotingPeriod(),
        ]);
    }
}
