{{-- SEO用解説コンテンツ（トップページのみ・初期HTMLに含めるためBladeでレンダリング） --}}
{{-- デザイン: 案A エディトリアル（カード廃止・罫線＋余白でフラット化） --}}
<section class="relative z-10" style="background: #FFF9F5">
    <div class="seo-editorial max-w-[440px] mx-auto px-5 pt-6 pb-16">

        {{-- 婚活偏差値とは --}}
        <section class="seo-block">
            <p class="seo-eyebrow">About</p>
            <h2 class="seo-title">婚活偏差値とは？</h2>
            <p>
                <strong>婚活偏差値</strong>とは、婚活市場でのあなたの立ち位置を、学力テストの偏差値と同じ感覚で数値化したものです。50が平均で、数値が高いほど婚活市場で選ばれやすい傾向にあることを示します。
            </p>
            <p>
                <!-- 当サイトの診断では、年齢・年収・コミュニケーション力・結婚への本気度など、性別選択を含む6つの質問への回答から<strong>30〜75の範囲</strong>で偏差値を算出。偏差値だけでなく、あなたの<strong>強み・弱み</strong>と<strong>相性のいいタイプ</strong>もあわせてわかります。 -->
            </p>
        </section>

        {{-- 算出方法 --}}
        <section class="seo-block">
            <p class="seo-eyebrow">Method</p>
            <h2 class="seo-title">算出方法とデータの根拠</h2>
            <p>
                診断ロジックは、<strong>IBJ婚活白書（2024年版）</strong>の成婚データと<strong>国税庁の統計データ</strong>をもとに設計したスコアリングです。男女で評価テーブルを分け、婚活市場の実態に近い形で採点しています。
            </p>
            <p>
                <!-- さらに詳しく知りたい方向けの<strong>本格診断</strong>では、学歴・貯蓄・身長などの質問を追加した計10問で、より精密なギャップ分析まで行います。 -->
            </p>
        </section>

        {{-- 偏差値の目安 --}}
        <section class="seo-block">
            <p class="seo-eyebrow">Scale</p>
            <h2 class="seo-title">婚活偏差値の目安</h2>
            <table class="seo-table">
                <!-- <thead>
                    <tr>
                        <th>偏差値</th>
                        <th>婚活市場での立ち位置</th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr>
                        <td class="score" style="color: #FCA0B2;">65 - 75</td>
                        <td>上位7%〜1%のトップ層</td>
                    </tr>
                    <tr>
                        <td class="score" style="color: #FCA0B2;">60 - 64</td>
                        <td>上位16%〜8%。かなり有利な層</td>
                    </tr>
                    <tr>
                        <td class="score" style="color: #FFB347;">55 - 59</td>
                        <td>上位31%〜19%。平均より上</td>
                    </tr>
                    <tr>
                        <td class="score" style="color: #B7ADAD;">45 - 54</td>
                        <td>平均圏</td>
                    </tr>
                    <tr>
                        <td class="score" style="color: #B7ADAD;">30 - 44</td>
                        <td>伸びしろ大!
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        {{-- FAQ --}}
        <section class="seo-block">
            <p class="seo-eyebrow">FAQ</p>
            <h2 class="seo-title">よくある質問</h2>
            <div class="seo-faq">
                <details open>
                    <summary><span class="q">Q.</span>婚活偏差値診断は無料ですか？</summary>
                    <p class="ans">完全無料で、会員登録も不要です。</p>
                </details>
                <details>
                    <summary><span class="q">Q.</span>個人情報の入力は必要ですか？</summary>
                    <p class="ans">氏名やメールアドレスなど、個人を特定できる情報の入力は一切ありません。回答内容は診断精度向上のための統計データとしてのみ利用します。</p>
                </details>
                <details>
                    <summary><span class="q">Q.</span>偏差値はどうやって計算していますか？</summary>
                    <p class="ans">IBJ婚活白書（2024年版）と国税庁の統計データをもとにした重み付きスコアリングで、30〜75の範囲の偏差値として算出しています。</p>
                </details>
                <!-- <details>
                    <summary><span class="q">Q.</span>偏差値が低いと結婚できないのでしょうか？</summary>
                    <p class="ans">そんなことはありません。婚活偏差値はあくまで現時点での参考指標です。診断結果では弱みと改善ポイントもお伝えするので、次の一歩に役立ててください。</p>
                </details> -->
            </div>
        </section>

        {{-- CTA --}}
        <div class="seo-cta text-center pt-4">
            <a href="#app" class="inline-block bg-konkatsu-pink hover:bg-konkatsu-pink-dark text-white text-sm font-black rounded-full px-10 py-4 shadow-md transition-colors">
                婚活偏差値を診断する
            </a>
        </div>
    </div>

    {{-- 案A 専用スタイル（脱カード・罫線ベース） --}}
    <style>
        /* スクロール表示（フェードイン）— JSが .seo-reveal を付与したときのみ作動 */
        .seo-editorial .seo-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .seo-editorial .seo-reveal.is-visible {
            opacity: 1;
            transform: none;
        }

        .seo-editorial .seo-block { padding: 28px 0; }
        .seo-editorial .seo-block:first-child { padding-top: 8px; }
        .seo-editorial .seo-block + .seo-block { border-top: 1px solid rgba(74, 61, 61, 0.10); }

        .seo-editorial .seo-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #A99C9C;
            margin: 0 0 10px;
        }
        .seo-editorial .seo-eyebrow::before {
            content: "";
            flex: none;
            width: 28px;
            height: 1px;
            background: currentColor;
            opacity: 0.6;
        }
        .seo-editorial .seo-title {
            font-size: 20px;
            font-weight: 800;
            color: #4A3D3D;
            letter-spacing: -0.01em;
            margin: 0 0 14px;
        }
        .seo-editorial p {
            font-size: 14px;
            line-height: 1.9;
            color: #6B5E5E;
            margin: 0 0 12px;
        }
        .seo-editorial p:last-child { margin-bottom: 0; }
        .seo-editorial strong { color: #4A3D3D; font-weight: 800; }

        /* 目安テーブル */
        .seo-editorial .seo-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .seo-editorial .seo-table thead th {
            text-align: left; font-size: 11px; font-weight: 700; color: #9A8E8E;
            padding: 0 0 10px; letter-spacing: 0.04em;
        }
        .seo-editorial .seo-table tbody td {
            padding: 9px 0;
            color: #6B5E5E; vertical-align: top; line-height: 1.6;
        }
        .seo-editorial .seo-table td.score {
            font-size: 18px; font-weight: 800; white-space: nowrap; padding-right: 18px;
            font-variant-numeric: tabular-nums; letter-spacing: 0.01em;
        }

        /* FAQ アコーディオン */
        .seo-editorial .seo-faq details { border-top: 1px solid rgba(74, 61, 61, 0.08); padding: 14px 0; }
        .seo-editorial .seo-faq summary {
            list-style: none; cursor: pointer;
            font-size: 14px; font-weight: 800; color: #6B5E5E;
            display: flex; align-items: baseline; gap: 8px;
        }
        .seo-editorial .seo-faq summary::-webkit-details-marker { display: none; }
        .seo-editorial .seo-faq summary .q { color: #FF6B8A; font-weight: 900; }
        .seo-editorial .seo-faq summary::after {
            content: "+"; margin-left: auto; color: #9A8E8E; font-weight: 700; font-size: 16px;
        }
        .seo-editorial .seo-faq details[open] summary { color: #4A3D3D; }
        .seo-editorial .seo-faq details[open] summary::after { content: "–"; }
        .seo-editorial .seo-faq .ans {
            font-size: 13.5px; line-height: 1.9; color: #6B5E5E;
            padding: 10px 0 2px 22px; margin: 0;
        }
    </style>

    {{-- スクロールで順に表示（About以降の各ブロック） --}}
    <script>
        (function () {
            var blocks = document.querySelectorAll('.seo-editorial .seo-block, .seo-editorial .seo-cta');
            if (!blocks.length) return;

            // モーション低減設定・非対応ブラウザでは隠さず通常表示（SEO・アクセシビリティ配慮）
            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduceMotion || !('IntersectionObserver' in window)) return;

            blocks.forEach(function (el) { el.classList.add('seo-reveal'); });

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

            blocks.forEach(function (el) { observer.observe(el); });
        })();
    </script>

    {{-- FAQ構造化データ --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "FAQPage",
        "mainEntity": [
            {
                "@@type": "Question",
                "name": "婚活偏差値診断は無料ですか？",
                "acceptedAnswer": { "@@type": "Answer", "text": "完全無料で、会員登録も不要です。所要時間は約1分です。" }
            },
            {
                "@@type": "Question",
                "name": "個人情報の入力は必要ですか？",
                "acceptedAnswer": { "@@type": "Answer", "text": "氏名やメールアドレスなど、個人を特定できる情報の入力は一切ありません。回答内容は診断精度向上のための統計データとしてのみ利用します。" }
            },
            {
                "@@type": "Question",
                "name": "偏差値はどうやって計算していますか？",
                "acceptedAnswer": { "@@type": "Answer", "text": "IBJ婚活白書（2024年版）と国税庁の統計データをもとにした重み付きスコアリングで、30〜75の範囲の偏差値として算出しています。" }
            },
            {
                "@@type": "Question",
                "name": "偏差値が低いと結婚できないのでしょうか？",
                "acceptedAnswer": { "@@type": "Answer", "text": "そんなことはありません。婚活偏差値はあくまで現時点での参考指標です。診断結果では弱みと改善ポイントもお伝えします。" }
            }
        ]
    }
    </script>
</section>
