<?php

namespace App\Http\Controllers;

use App\Services\News\Delfi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request, Delfi $delfi): Response
    {
        $news = $delfi->getNews();

        return Inertia::render('Dashboard', compact('news'));
    }
}
