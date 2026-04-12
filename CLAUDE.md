# CLAUDE.md

このファイルはリポジトリ内のコードを扱う際に Claude Code (claude.ai/code) へのガイダンスを提供します。

## コマンド

```bash
# 初期セットアップ（依存関係インストール・キー生成・マイグレーション・ビルド）
npm run setup

# 開発サーバー起動（Laravel・Queue・ログ・Vite を並列起動）
npm run dev
php artisan serve

# 全テスト実行
composer run test
# または
php artisan test

# 単一テストファイルの実行
php artisan test tests/Feature/ExampleTest.php

# フロントエンドアセットのプロダクションビルド
npm run build

# PHP コードフォーマット
./vendor/bin/pint
```

## アーキテクチャ

**Laravel 13 + Inertia.js + Vue 3** で構築された、婚活偏差値アプリケーション。

### リクエストフロー

1. `GET /` → `DiagnosisController@index` が質問配列とともに Inertia ページをレンダリング
2. `POST /api/diagnosis/calculate` → `DiagnosisController@calculate` が入力を検証し、`ScoreCalculator` を呼び出してスコアを算出・保存・返却

### バックエンド

- [app/Http/Controllers/DiagnosisController.php](app/Http/Controllers/DiagnosisController.php) — メインコントローラー。性別でフィルタリングした質問の提供とスコア計算リクエストの処理を担当
- [app/Services/ScoreCalculator.php](app/Services/ScoreCalculator.php) — コアロジック。IBJ婚活白書（2024年版）・国税庁データに基づく重み付きスコアリングテーブルから偏差値（30〜75）・パーセンタイル・コメント・強み/弱み項目・マッチタイプ・ギャップ分析を算出
- [app/Models/DiagnosisResult.php](app/Models/DiagnosisResult.php) — 診断結果（性別・回答JSON・偏差値・is_extended・is_high_score）を分析用に保存

### フロントエンド

フロントエンドはすべて [resources/js/](resources/js/) に配置。単一の Inertia ページ [Pages/Diagnosis/Index.vue](resources/js/Pages/Diagnosis/Index.vue) が以下の4画面をコンポーネントとして管理：

1. `IntroScreen` — 性別選択
2. `QuestionScreen` — 基本5問＋性別別の追加質問
3. `BranchScreen` — 簡易診断／本格診断の選択
4. `ResultScreen` — 偏差値・パーセンタイル・コメント・分析結果の表示

フロントエンドは Axios 経由で `/api/diagnosis/calculate` にPOSTし、レスポンスを `ResultScreen` でレンダリング。

### 設計上の重要ポイント

- **モバイルファースト**、最大幅 440px
- **Tailwind CSS + DaisyUI** に独自の「konkatsu」カラーパレット（[tailwind.config.js](tailwind.config.js) で定義）
- 日本語テキストに **Zen Maru Gothic** フォントを使用
- ローカル開発は **SQLite**、テストはインメモリ SQLite（`phpunit.xml` で設定）
- Inertia ミドルウェア [app/Http/Middleware/HandleInertiaRequests.php](app/Http/Middleware/HandleInertiaRequests.php) でグローバルデータを共有
