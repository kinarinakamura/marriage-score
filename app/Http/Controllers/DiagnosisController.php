<?php

namespace App\Http\Controllers;

use App\Services\ScoreCalculator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiagnosisController extends Controller
{
    public function __construct(
        private ScoreCalculator $calculator
    ) {}

    /**
     * 診断トップページ
     */
    public function index()
    {
        return Inertia::render('Diagnosis/Index', [
            'questions' => $this->getQuestions(),
        ]);
    }

    /**
     * スコア計算API
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'gender'             => 'required|in:male,female',
            'answers'            => 'required|array',
            'partner_priorities' => 'nullable|array|max:2',
            'is_extended'        => 'boolean',
        ]);

        $result = $this->calculator->calculate(
            gender: $validated['gender'],
            answers: $validated['answers'],
            partnerPriorities: $validated['partner_priorities'] ?? [],
        );

        // 回答を保存（集計用）
        $this->storeAnswer($validated, $result);

        return response()->json($result);
    }

    /**
     * 回答データを保存
     */
    private function storeAnswer(array $validated, array $result): void
    {
        \App\Models\DiagnosisResult::create([
            'gender'       => $validated['gender'],
            'answers'      => $validated['answers'],
            'is_extended'  => $validated['is_extended'] ?? false,
            'hensachi'     => $result['hensachi'],
            'is_high_score' => $result['is_high_score'],
        ]);
    }

    /**
     * 質問データ
     */
    private function getQuestions(): array
    {
        return [
            // === 共通 基本問 ===
            [
                'id'       => 'age',
                'text'     => 'あなたの年齢は？',
                'hint'     => '',
                'type'     => 'common',
                'category' => 'basic',
                'options'  => [
                    '25歳以下',
                    '26〜29歳',
                    '30〜34歳',
                    '35〜39歳',
                    '40〜44歳',
                    '45歳以上',
                ],
            ],
            [
                'id'       => 'income',
                'text'     => '年収はどのくらい？',
                'hint'     => '',
                'type'     => 'common',
                'category' => 'basic',
                'options'  => [
                    '200万円以下',
                    '200万円〜350万円',
                    '350万円〜500万円',
                    '500万円〜700万円',
                    '700万円〜850万円',
                    '850万円〜1,000万円',
                    '1,000万円以上',
                ],
            ],
            [
                'id'       => 'communication',
                'text'     => 'コミュニケーションの得意度は？',
                'hint'     => '自分の感覚でOKです',
                'type'     => 'common',
                'category' => 'basic',
                'options'  => [
                    '得意な方',
                    '普通かな',
                    'ちょっと苦手',
                    'かなり苦手',
                ],
            ],
            [
                'id'       => 'living',
                'text'     => '住まいの環境は？',
                'hint'     => '',
                'type'     => 'common',
                'category' => 'basic',
                'options'  => [
                    'ひとり暮らし',
                    '実家暮らし',
                    'シェアハウス等',
                    '持ち家あり',
                ],
            ],
            [
                'id'       => 'seriousness',
                'text'     => '結婚への本気度は？',
                'hint'     => '',
                'type'     => 'common',
                'category' => 'basic',
                'options'  => [
                    '今すぐしたい',
                    '1〜2年以内には',
                    'いい人がいれば',
                    'まだ考え中',
                ],
            ],

            // === 女性専用 基本問 ===
            [
                'id'       => 'appearance_female',
                'text'     => '外見について周りからよく言われるのは？',
                'hint'     => '',
                'type'     => 'female',
                'category' => 'basic',
                'options'  => [
                    'かわいいね、と言われる',
                    'きれいだね、と言われる',
                    'おしゃれだね、と言われる',
                    '雰囲気がいいね、と言われる',
                    'あまり言われたことがない',
                ],
            ],
            [
                'id'       => 'personality_female',
                'text'     => '周りからよく言われる性格は？',
                'hint'     => '',
                'type'     => 'female',
                'category' => 'basic',
                'options'  => [
                    'しっかりしてるね',
                    '明るいね・楽しいね',
                    'やさしいね・癒されるね',
                    'マイペースだね',
                ],
            ],

            // === 男性専用 基本問 ===
            [
                'id'       => 'occupation_male',
                'text'     => '今のお仕事は？',
                'hint'     => '',
                'type'     => 'male',
                'category' => 'basic',
                'options'  => [
                    '正社員（大手・公務員）',
                    '正社員（中小・ベンチャー）',
                    '専門職（医療・士業・教育など）',
                    '契約・派遣社員',
                    '自営業・フリーランス',
                    'パート・アルバイト・その他',
                ],
            ],
            [
                'id'       => 'housework_male',
                'text'     => '家事はどのくらいできる？',
                'hint'     => '',
                'type'     => 'male',
                'category' => 'basic',
                'options'  => [
                    '一通りできる（料理も得意）',
                    '基本的なことはできる',
                    '最低限はやっている',
                    'ほとんどしていない',
                ],
            ],

            [
                'id'           => 'partner_priorities',
                'text'         => '相手に求める条件で大事なものを2つ選んでください',
                'hint'         => '',
                'type'         => 'common',
                'category'     => 'basic',
                'select_count' => 2,
                'options'      => [
                    '年収・経済力',
                    '外見・スタイル',
                    '性格・価値観の一致',
                    '年齢',
                ],
            ],

            // === 追加問 ===
            [
                'id'       => 'education',
                'text'     => '最終学歴は？',
                'hint'     => '',
                'type'     => 'common',
                'category' => 'extended',
                'options'  => [
                    '大学院卒',
                    '大卒（難関校）',
                    '大卒（その他）',
                    '短大・専門卒',
                    '高卒・その他',
                ],
            ],
            [
                'id'       => 'savings',
                'text'     => '貯蓄額はどのくらい？',
                'hint'     => 'ざっくりで大丈夫です',
                'type'     => 'common',
                'category' => 'extended',
                'options'  => [
                    '1,000万以上',
                    '500〜1,000万',
                    '200〜500万',
                    '50〜200万',
                    '50万未満',
                ],
            ],
            [
                'id'       => 'height_male',
                'text'     => '身長は？',
                'hint'     => '',
                'type'     => 'male',
                'category' => 'extended',
                'options'  => [
                    '〜165cm',
                    '166〜170cm',
                    '171〜175cm',
                    '176〜180cm',
                    '181cm〜',
                ],
            ],
            [
                'id'       => 'height_female',
                'text'     => '身長は？',
                'hint'     => '',
                'type'     => 'female',
                'category' => 'extended',
                'options'  => [
                    '〜155cm',
                    '156〜160cm',
                    '161〜165cm',
                    '166〜170cm',
                    '171cm〜',
                ],
            ],
            [
                'id'       => 'housework_female',
                'text'     => '家事はどのくらいできる？',
                'hint'     => '',
                'type'     => 'female',
                'category' => 'extended',
                'options'  => [
                    '一通りできる（料理も得意）',
                    '基本的なことはできる',
                    '最低限はやっている',
                    'ほとんどしていない',
                ],
            ],
            [
                'id'       => 'appearance_male',
                'text'     => '外見について周りから言われることは？',
                'hint'     => '',
                'type'     => 'male',
                'category' => 'extended',
                'options'  => [
                    'かっこいいね、と言われる',
                    '清潔感あるね、と言われる',
                    'おしゃれだね、と言われる',
                    '雰囲気がいいね、と言われる',
                    'あまり言われたことがない',
                ],
            ],
        ];
    }
}
