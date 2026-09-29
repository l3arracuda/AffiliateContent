<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AffiliateContent') · AffiliateContent</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">A</span><span>Affiliate<br><strong>Content</strong></span></a>
        <div class="workspace-label">WORKSPACE <span class="mock-pill">MOCK DATA</span></div>
        <nav aria-label="Main navigation">
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="{{ request()->routeIs('market-watch.*') ? 'active' : '' }}" href="{{ route('market-watch.index') }}">Market Watch</a>
            <a class="{{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
            <a class="{{ request()->routeIs('contents.*') ? 'active' : '' }}" href="{{ route('contents.index') }}">Content</a>
            <a class="{{ request()->routeIs('pages.*') ? 'active' : '' }}" href="{{ route('pages.index') }}">Pages</a>
            <a class="{{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">Settings</a>
        </nav>
        <div class="sidebar-bottom">Phase 0 Foundation<br><span>v0.1.0 · Internal preview</span></div>
    </aside>
    <main class="main">
        <header class="topbar"><span>Affiliate command center</span><span class="topbar-right">Phase 0 · Demo environment</span></header>
        <div class="page-wrap">
            @if(session('success')) <div class="alert success" role="status">{{ session('success') }}</div> @endif
            @if($errors->any()) <div class="alert error" role="alert"><strong>Please check the form:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
