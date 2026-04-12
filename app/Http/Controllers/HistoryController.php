<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = [
            '2026/4/6' => 'サイトをリリースしました',
        ];

        return Inertia::render('History/Index', [
            'histories' => $histories,
        ]);
    }
}
