@php
    $seoTitle = '婚活偏差値診断｜6つの質問であなたの婚活力を無料チェック';
    $seoDescription = 'あなたの婚活偏差値を6つの質問で無料診断。IBJ婚活白書・国税庁データに基づいて偏差値・上位パーセント・強みと弱み・相性のいいタイプがわかります。登録不要、約1分で完了。';
    $seoImage = url('/images/ogp.png');
@endphp
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seoTitle }}</title>
    <link rel="icon" type="image/png" href="/images/logo_ring.png">
    <meta name="description" content="{{ $seoDescription }}">

    {{-- フォント: preconnect で接続を先行させ、@import のリクエストチェーンを回避（LCP改善） --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- OGP --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="婚活偏差値診断">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="ja_JP">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{-- 構造化データ --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebApplication",
        "name": "婚活偏差値診断",
        "url": "{{ url('/') }}",
        "description": "{{ $seoDescription }}",
        "applicationCategory": "LifestyleApplication",
        "operatingSystem": "Web",
        "inLanguage": "ja",
        "offers": {
            "@@type": "Offer",
            "price": "0",
            "priceCurrency": "JPY"
        }
    }
    </script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
    @if (request()->routeIs('diagnosis.index'))
        @include('partials.seo-content')
    @endif
</body>
</html>
