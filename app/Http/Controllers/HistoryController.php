<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = [
            '2026/4/6' => 'サイトをリリースしました',
            '2026/4/25' => '偏差値の計算方法を改善しました',
        ];

        return Inertia::render('History/Index', [
            'histories' => $histories,
        ]);
    }
}
