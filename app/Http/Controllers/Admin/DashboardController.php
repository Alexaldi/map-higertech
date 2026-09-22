<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ClientPartner;
use App\Models\InternshipApplication;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // STATISTIK
        $totalInternships = InternshipApplication::count();
        $totalProducts = Product::count();
        $totalClients = ClientPartner::count();
        $totalArticles = Article::count();

        // DATA TERBARU
        $latestInternship = InternshipApplication::latest('created_at')->first();
        $latestProduct = Product::latest('created_at')->first();
        $latestClient = ClientPartner::latest('created_at')->first();
        $latestArticle = Article::latest('created_at')->first();

        // PENDAFTARAN MAGANG PENDING
        $pendingInternships = InternshipApplication::query()
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // STATISTIK STATUS MAGANG
        $internshipStatus = [
            'pending' => InternshipApplication::where('status', 'pending')->count(),
            'reviewing' => InternshipApplication::where('status', 'reviewing')->count(),
            'accepted' => InternshipApplication::where('status', 'accepted')->count(),
            'rejected' => InternshipApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard.index', compact(
            'totalInternships',
            'totalProducts',
            'totalClients',
            'totalArticles',
            'latestInternship',
            'latestProduct',
            'latestClient',
            'latestArticle',
            'pendingInternships',
            'internshipStatus'
        ));
    }
}