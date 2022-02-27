<?php

namespace App\Http\Controllers;

use Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class MyHelper
{
    public static function renderWithRole($page, $returnArray = []) {
        $user = Auth::user();
        $role = $user->role_id;

        $returnArray["role"] = $role;

        return Inertia::render($page, $returnArray);
    }


    public static function isVotingPeriod() {
        // Check if current time is voting period
        return !MyHelper::isBeforeVotingPeriod() && !MyHelper::isAfterVotingPeriod();
    }

    public static function isBeforeVotingPeriod() {
        // Check if current time is before-voting period
        $tz = 'Asia/Jakarta'; // +07:00

        $currentDate = Carbon::now($tz);
        $startDate = Carbon::create(2022, 2, 26, 0, 0, 0, $tz); // Year, Month, Date, Hour, Minute, Second

        return $currentDate->lessThan($startDate);
    }

    public static function isAfterVotingPeriod() {
        // Check if current time is after-voting period
        $tz = 'Asia/Jakarta'; // +07:00

        $currentDate = Carbon::now($tz);
        $stopDate = Carbon::create(2022, 3, 17, 23, 0, 0, $tz); // Year, Month, Date, Hour, Minute, Second

        return $currentDate->greaterThan($stopDate);
    }

    public static function isResultOpenPeriod() {
        // Check if current time is open-result period
        $tz = 'Asia/Jakarta'; // +07:00

        $currentDate = Carbon::now($tz);
        $resultOpenTime = Carbon::create(2021, 2, 18, 0, 0, 0, $tz); // Year, Month, Date, Hour, Minute, Second

        return $currentDate->greaterThan($resultOpenTime);
    }
}
