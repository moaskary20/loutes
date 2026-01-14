@php
    $logoUrl = \App\Helpers\SiteHelper::getLogo();
    $hasCustomLogo = \App\Helpers\SiteHelper::hasCustomLogo();
@endphp

<div class="logo">
    @if($hasCustomLogo)
        <a href="{{ route('home') }}" style="display: inline-block;">
            <img src="{{ $logoUrl }}" alt="Logo" class="logo-image" style="max-height: 50px; max-width: 150px; object-fit: contain; display: block;">
        </a>
    @else
        <div class="logo-icon">L</div>
        <div class="logo-text">
            <span class="logo-text-ar">اللوتس</span>
            <span class="logo-text-en">LOTUS</span>
        </div>
    @endif
</div>
