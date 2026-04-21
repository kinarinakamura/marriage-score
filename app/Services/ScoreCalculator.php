<?php

namespace App\Services;

class ScoreCalculator
{
    /**
     * 男女別・質問別のスコアテーブル
     * IBJ成婚白書(2024)を参考に配点
     *
     * キー: 質問ID
     * 値: [選択肢index => [male_score, female_score]]
     */
    private array $scoreTable = [
        // Q1: 年齢
        // 男性: 30代前半が最も成婚率高い(IBJ) / 女性: 20代〜30代前半が高い
        'age' => [
            0 => ['male' => 70, 'female' => 85], // 25歳以下
            1 => ['male' => 80, 'female' => 80], // 26〜29歳
            2 => ['male' => 85, 'female' => 70], // 30〜34歳
            3 => ['male' => 65, 'female' => 50], // 35〜39歳
            4 => ['male' => 45, 'female' => 35], // 40〜44歳
            5 => ['male' => 30, 'female' => 25], // 45歳以上
        ],

        // Q2: 年収
        // 男性: 500万がボーダー、800万で申込4倍(IBJ) / 女性: 300万以上で好印象
        'income' => [
            0 => ['male' => 20, 'female' => 45], // 〜200万
            1 => ['male' => 35, 'female' => 55], // 〜350万
            2 => ['male' => 55, 'female' => 65], // 〜500万
            3 => ['male' => 75, 'female' => 70], // 〜700万
            4 => ['male' => 85, 'female' => 75], // 〜850万
            5 => ['male' => 90, 'female' => 80], // 〜1,000万
            6 => ['male' => 95, 'female' => 85], // 1,000万以上
        ],

        // Q3: コミュニケーションの得意度
        'communication' => [
            0 => ['male' => 85, 'female' => 85], // 得意な方
            1 => ['male' => 65, 'female' => 65], // 普通かな
            2 => ['male' => 40, 'female' => 40], // ちょっと苦手
            3 => ['male' => 30, 'female' => 30], // かなり苦手
        ],

        // Q4: 結婚への本気度
        'seriousness' => [
            0 => ['male' => 85, 'female' => 85], // 今すぐしたい
            1 => ['male' => 75, 'female' => 75], // 1〜2年以内には
            2 => ['male' => 50, 'female' => 50], // いい人がいれば
            3 => ['male' => 40, 'female' => 40], // まだ考え中
        ],

        // Q7 女性専用: 外見評価
        'appearance_female' => [
            0 => ['female' => 85], // かわいいね
            1 => ['female' => 85], // きれいだね
            2 => ['female' => 75], // おしゃれだね
            3 => ['female' => 65], // 雰囲気がいいね
            4 => ['female' => 35], // あまり言われたことがない
        ],

        // Q7 男性専用: 職業
        'occupation_male' => [
            0 => ['male' => 90], // 正社員（大手・公務員）
            1 => ['male' => 70], // 正社員（中小・ベンチャー）
            2 => ['male' => 80], // 専門職
            3 => ['male' => 45], // 契約・派遣社員
            4 => ['male' => 60], // 自営業・フリーランス
            5 => ['male' => 25], // パート・アルバイト・その他
        ],

        // Q8 女性専用: 性格タイプ
        'personality_female' => [
            0 => ['female' => 70], // しっかりしてるね
            1 => ['female' => 75], // 明るいね・楽しいね
            2 => ['female' => 70], // やさしいね・癒されるね
            3 => ['female' => 55], // マイペースだね
        ],

        // Q8 男性専用: 家事力
        'housework_male' => [
            0 => ['male' => 85], // 一通りできる
            1 => ['male' => 65], // 基本的なことはできる
            2 => ['male' => 45], // 最低限はやっている
            3 => ['male' => 25], // ほとんどしていない
        ],

        // === 追加4問 ===

        // Q9: 学歴
        'education' => [
            0 => ['male' => 85, 'female' => 75], // 大学院卒
            1 => ['male' => 80, 'female' => 70], // 大卒（難関校）
            2 => ['male' => 65, 'female' => 60], // 大卒（その他）
            3 => ['male' => 45, 'female' => 50], // 短大・専門卒
            4 => ['male' => 30, 'female' => 40], // 高卒・その他
        ],

        // Q10: 貯蓄額
        'savings' => [
            0 => ['male' => 90, 'female' => 85], // 1,000万以上
            1 => ['male' => 75, 'female' => 75], // 500〜1,000万
            2 => ['male' => 60, 'female' => 65], // 200〜500万
            3 => ['male' => 40, 'female' => 50], // 50〜200万
            4 => ['male' => 20, 'female' => 30], // 50万未満
        ],

        // Q11: 身長（男性）
        'height_male' => [
            0 => ['male' => 40], // 〜165cm
            1 => ['male' => 55], // 166〜170cm
            2 => ['male' => 80], // 171〜175cm
            3 => ['male' => 85], // 176〜180cm
            4 => ['male' => 90], // 181cm〜
        ],

        // Q11: 身長（女性）
        'height_female' => [
            0 => ['female' => 65], // 〜155cm
            1 => ['female' => 75], // 156〜160cm
            2 => ['female' => 75], // 161〜165cm
            3 => ['female' => 65], // 166〜170cm
            4 => ['female' => 55], // 171cm〜
        ],

        // Q12 女性: 家事力
        'housework_female' => [
            0 => ['female' => 80], // 一通りできる
            1 => ['female' => 65], // 基本的なことはできる
            2 => ['female' => 45], // 最低限はやっている
            3 => ['female' => 30], // ほとんどしていない
        ],

        // Q12 男性: 外見への意識
        'appearance_male' => [
            0 => ['male' => 80], // かわいいね（→清潔感がある）
            1 => ['male' => 80], // きれいだね（→かっこいい）
            2 => ['male' => 70], // おしゃれだね
            3 => ['male' => 60], // 雰囲気がいいね
            4 => ['male' => 30], // あまり言われたことがない
        ],
    ];

    /**
     * 質問ごとの重み
     */
    private array $weights = [
        'age'                => 5,
        'income'             => 5,
        'communication'      => 3,
        'seriousness'        => 3,
        'appearance_female'  => 4,
        'occupation_male'    => 4,
        'personality_female' => 2,
        'housework_male'     => 3,
        // 追加問
        'education'          => 2,
        'savings'            => 2,
        'height_male'        => 3,
        'height_female'      => 2,
        'housework_female'   => 3,
        'appearance_male'    => 3,
    ];

    /**
     * 項目ラベル（コメント生成用）
     */
    private array $labels = [
        'age'                => '年齢的なアドバンテージ',
        'income'             => '経済的な安定感',
        'communication'      => 'コミュニケーション力',
        'seriousness'        => '結婚への真剣さ',
        'appearance_female'  => '外見の好印象',
        'occupation_male'    => '仕事の安定感',
        'personality_female' => '親しみやすい人柄',
        'housework_male'     => '生活力の高さ',
        'education'          => '学歴の強み',
        'savings'            => '貯蓄の安心感',
        'height_male'        => '身長のアドバンテージ',
        'height_female'      => 'スタイルの良さ',
        'housework_female'   => '生活力の高さ',
        'appearance_male'    => '外見の好印象',
    ];

    /**
     * メイン計算
     *
     * @param string $gender 'male' or 'female'
     * @param array $answers ['question_id' => selected_index, ...]
     * @return array
     */
    public function calculate(string $gender, array $answers): array
    {
        $totalWeightedScore = 0;
        $totalWeight = 0;
        $itemScores = [];

        foreach ($answers as $questionId => $selectedIndex) {
            if (!isset($this->scoreTable[$questionId])) {
                continue;
            }

            $table = $this->scoreTable[$questionId];
            if (!isset($table[$selectedIndex])) {
                continue;
            }

            $score = $table[$selectedIndex][$gender] ?? null;
            if ($score === null) {
                continue;
            }

            $weight = $this->weights[$questionId] ?? 1;
            $totalWeightedScore += $score * $weight;
            $totalWeight += $weight;
            $itemScores[$questionId] = $score;
        }

        // 偏差値に変換（30〜75のレンジ）
        $rawAverage = $totalWeight > 0 ? $totalWeightedScore / $totalWeight : 50;
        $hensachi = $this->convertToHensachi($rawAverage);

        // 上位2項目・下位2項目を特定
        arsort($itemScores);
        $topItems = array_slice(array_keys($itemScores), 0, 2);

        $bottomCandidates = array_filter($itemScores, fn($k) => $k !== 'age', ARRAY_FILTER_USE_KEY);
        asort($bottomCandidates);
        $bottomItems = array_slice(array_keys($bottomCandidates), 0, 2);

        // パーセンタイル（簡易計算）
        $percentile = $this->calculatePercentile($hensachi);

        // コメント生成
        $isHighScore = $hensachi >= 55;
        $comment = $this->generateComment($isHighScore, $topItems, $bottomItems);

        // 相性タイプ
        $matchType = $this->determineMatchType($gender, $answers, $itemScores, $isHighScore);

        return [
            'hensachi'      => $hensachi,
            'is_high_score'  => $isHighScore,
            'percentile'    => $percentile,
            'comment'       => $comment,
            'top_items'     => array_map(fn($id) => $this->labels[$id] ?? $id, $topItems),
            'bottom_items'  => array_map(fn($id) => $this->labels[$id] ?? $id, $bottomItems),
            'match_type'    => $matchType,
        ];
    }

    /**
     * 素点を偏差値(30〜75)に変換
     */
    private function convertToHensachi(float $rawAverage): int
    {
        // rawAverage: 20〜95 → hensachi: 30〜75
        $min = 20;
        $max = 95;
        $normalized = ($rawAverage - $min) / ($max - $min);
        $normalized = max(0, min(1, $normalized));

        $hensachi = 30 + round($normalized * 45);
        return (int) max(30, min(75, $hensachi));
    }

    /**
     * パーセンタイル簡易計算
     */
    private function calculatePercentile(int $hensachi): ?int
    {
        if ($hensachi < 55) {
            return null; // 低スコアではパーセンタイルを表示しない
        }

        // 偏差値→上位%（正規分布の近似）
        $percentileMap = [
            55 => 31, 56 => 27, 57 => 24, 58 => 21, 59 => 19,
            60 => 16, 61 => 14, 62 => 12, 63 => 10, 64 => 8,
            65 => 7, 66 => 5, 67 => 4, 68 => 3, 69 => 3,
            70 => 2, 71 => 2, 72 => 1, 73 => 1, 74 => 1, 75 => 1,
        ];

        return $percentileMap[$hensachi] ?? 1;
    }

    /**
     * コメント生成
     */
    private function generateComment(bool $isHighScore, array $topItems, array $bottomItems): string
    {
        if ($isHighScore) {
            $label1 = $this->labels[$topItems[0]] ?? '魅力';
            $label2 = isset($topItems[1]) ? $this->labels[$topItems[1]] ?? '人柄' : '人柄';
            return "あなたの強みは「{$label1}」と「{$label2}」です。これは婚活市場でとても魅力的なポイントです。自信を持っていきましょう！";
        }

        $label1 = $this->labels[$bottomItems[0]] ?? '自分磨き';
        $label2 = isset($bottomItems[1]) ? $this->labels[$bottomItems[1]] ?? '行動力' : '行動力';
        return "あなたの伸びしろは「{$label1}」と「{$label2}」です。ここを少し意識するだけで、婚活市場での印象がグッと変わりそうです！";
    }

    /**
     * 相性タイプ判定
     * 高スコア → 強み領域から、低スコア → 弱み領域から相性タイプを決定
     */
    private function determineMatchType(string $gender, array $answers, array $itemScores, bool $isHighScore): array
    {
        $domains = [
            'economy'       => ['income', 'savings', 'occupation_male', 'education'],   // 経済力
            'communication' => ['communication', 'seriousness', 'personality_female'],  // コミュ力・真剣さ
            'lifestyle'     => ['housework_male', 'housework_female'],                  // 生活力
            'appearance'    => ['height_male', 'height_female', 'appearance_male', 'appearance_female'],  // 外見
            ];

        // 各領域のスコア平均を計算
        $domainScores = [];
        foreach ($domains as $domain => $keys) {
            $scores = array_values(array_filter(
                array_map(fn($k) => $itemScores[$k] ?? null, $keys),
                fn($s) => $s !== null
            ));
            if (count($scores) > 0) {
                $domainScores[$domain] = array_sum($scores) / count($scores);
            }
        }

        if (empty($domainScores)) {
            return ['label' => 'あなたに合うパートナー', 'text' => '誠実で一緒に成長できる人が◎'];
        }

        $descriptions = [
            'strength' => [
                'economy'       => ['label' => '経済力が強みのあなたには', 'text' => '将来設計を一緒に語れる、堅実なパートナーが◎'],
                'communication' => ['label' => 'コミュ力が強みのあなたには', 'text' => '一緒にいて会話が弾む、感受性豊かな人が◎'],
                'lifestyle'     => ['label' => '生活力が強みのあなたには', 'text' => '家庭を大切にする価値観を共有できる人が◎'],
                'appearance'    => ['label' => '外見への意識が強みのあなたには', 'text' => '外見に気を遣う、清潔感のある人が◎'],
            ],
            'weakness' => [
                'economy'       => ['label' => '経済面が伸びしろのあなたには', 'text' => '経済的に安定していて、生活を一緒に支えてくれる人が◎'],
                'communication' => ['label' => 'コミュ力が伸びしろのあなたには', 'text' => '穏やかに受け止めてくれる、包容力のある人が◎'],
                'lifestyle'     => ['label' => '生活力が伸びしろのあなたには', 'text' => '家庭的でサポート上手な、頼れるパートナーが◎'],
                'appearance'    => ['label' => '外見が伸びしろのあなたには', 'text' => '外見より内面や相性を大切にしてくれる人が◎'],
            ],
        ];

        if ($isHighScore) {
            arsort($domainScores);
            $key = array_key_first($domainScores);
            return $descriptions['strength'][$key];
        } else {
            asort($domainScores);
            $key = array_key_first($domainScores);
            return $descriptions['weakness'][$key];
        }
    }
}
