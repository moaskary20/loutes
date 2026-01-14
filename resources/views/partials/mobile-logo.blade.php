@php
    $logoUrl = \App\Helpers\SiteHelper::getLogo();
    $hasCustomLogo = \App\Helpers\SiteHelper::hasCustomLogo();
@endphp

<div class="mobile-menu-logo">
    @if($hasCustomLogo)
        <img src="{{ $logoUrl }}" alt="Logo" style="max-height: 40px; max-width: 120px; object-fit: contain; display: block;">
    @else
        <div class="logo-icon" style="width: 40px; height: 40px; font-size: 20px;">L</div>
        <div class="logo-text">
            <span class="logo-text-ar" style="font-size: 18px;">اللوتس</span>
            <span class="logo-text-en" style="font-size: 12px;">LOTUS</span>
        </div>
    @endif
</div>
