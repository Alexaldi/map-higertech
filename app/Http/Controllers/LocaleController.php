<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    protected array $supported = ['id', 'en'];

    public function switch(Request $request, string $lang): RedirectResponse
    {
        if (!in_array($lang, $this->supported)) {
            $lang = 'id';
        }

        session(['locale' => $lang]);

        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
