<!-- For Google -->
<meta name="application-name" content="{{ config('app.name') }}" />
<meta name="author" content="{{ config('app.name') }}" />
<meta name="copyright" content="{{ config('app.name') }}" />
<meta name="keywords" content="{{ $keywords }}">
<meta name="description" content="{{ $description }}">

<!-- For Facebook -->
<meta property="og:title" content="{{ $title }}" />
<meta property="og:type" content="article" />
<meta property="og:image" content="{{ $image }}" />
<meta property="og:url" content="{{ $url }}" />
<meta property="og:description" content="{{ $description }}" />

<!-- For Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:site" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">
