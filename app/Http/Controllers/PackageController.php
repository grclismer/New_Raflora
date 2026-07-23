<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of active packages.
     */
    public function index(): View
    {
        $packages = Package::where('is_active', true)->get();

        return view('packages.index', [
            'packages' => $packages,
        ]);
    }
}
