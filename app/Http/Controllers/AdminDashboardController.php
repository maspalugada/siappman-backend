<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $instrumentTypeCount = InstrumentType::count();
        $unitCount = Unit::count();
        $locationCount = Location::count();

        return view('dashboard.admin.index', compact('instrumentTypeCount', 'unitCount', 'locationCount'));
    }
}
