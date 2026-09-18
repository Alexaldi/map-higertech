<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Services\Admin\TutorialService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TutorialController extends Controller
{
    public function __construct(private readonly TutorialService $tutorialService) {}

    public function index(Request $request): View
    {
        $search = $request->query('q');
        $type = $request->query('type');

        $tutorials = $this->tutorialService->getPublished($search, $type);

        $types = Tutorial::published()
            ->whereNotNull('type')
            ->select('type')
            ->distinct()
            ->pluck('type');

        return view('tutorials.index', compact('tutorials', 'types', 'search', 'type'));
    }

    public function show(string $slug): View
    {
        $tutorial = Tutorial::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentTutorials = Tutorial::published()
            ->where('id', '!=', $tutorial->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('tutorials.show', compact('tutorial', 'recentTutorials'));
    }
}

