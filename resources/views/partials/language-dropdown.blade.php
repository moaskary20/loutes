<style>
    .language-dropdown {
        position: relative;
        display: inline-block;
        z-index: 1001;
    }

    .language-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        color: white;
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        min-width: 100px;
        justify-content: space-between;
    }

    .language-dropdown-btn:hover,
    .language-dropdown-btn:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        outline: none;
    }

    .language-dropdown-btn[aria-expanded="true"] {
        background: rgba(255, 255, 255, 0.25);
    }

    .language-dropdown-btn svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .language-dropdown-btn .chevron {
        transition: transform 0.2s ease;
    }

    .language-dropdown-btn[aria-expanded="true"] .chevron {
        transform: rotate(180deg);
    }

    .language-dropdown-content {
        display: none;
        position: absolute;
        {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 0;
        min-width: 160px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        margin-top: 6px;
        border: 1px solid #e5e7eb;
        z-index: 2000;
    }

    .language-dropdown-content.show {
        display: block;
        animation: dropdownFadeIn 0.15s ease;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .language-dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.15s ease;
        cursor: pointer;
        background: none;
        border: none;
        width: 100%;
        text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        font-family: inherit;
    }

    .language-dropdown-item:hover,
    .language-dropdown-item:focus {
        background: #f3f4f6;
        color: #044898;
        outline: none;
    }

    .language-dropdown-item.active {
        background: #e8f0fe;
        color: #044898;
        font-weight: 600;
    }

    .language-dropdown-item .flag {
        font-size: 16px;
        flex-shrink: 0;
    }

    .language-dropdown-item.ar {
        font-family: 'Tajawal', sans-serif;
    }

    .language-dropdown-item .check-icon {
        margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: auto;
        width: 16px;
        height: 16px;
        color: #044898;
        opacity: 0;
    }

    .language-dropdown-item.active .check-icon {
        opacity: 1;
    }

    /* Screen reader only */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .language-dropdown-btn {
            padding: 6px 10px;
            font-size: 13px;
            min-width: 85px;
        }

        .language-dropdown-btn svg {
            width: 14px;
            height: 14px;
        }

        .language-dropdown-content {
            min-width: 140px;
        }

        .language-dropdown-item {
            padding: 10px 14px;
            font-size: 13px;
        }
    }
</style>

<div class="language-dropdown" role="region" aria-label="{{ app()->getLocale() == 'ar' ? 'مبدل اللغة' : 'Language Switcher' }}">
    <button
        type="button"
        class="language-dropdown-btn"
        id="languageDropdownBtn"
        aria-haspopup="listbox"
        aria-expanded="false"
        aria-controls="languageDropdown"
        aria-label="{{ app()->getLocale() == 'ar' ? 'اللغة الحالية: العربية. اضغط لتغيير اللغة' : 'Current language: English. Press to change language' }}"
    >
        <span class="flag">{{ app()->getLocale() == 'ar' ? '🇸🇦' : '🇺🇸' }}</span>
        <span>{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
        <svg class="chevron" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
        </svg>
    </button>

    <div
        class="language-dropdown-content"
        id="languageDropdown"
        role="listbox"
        aria-labelledby="languageDropdownBtn"
        tabindex="-1"
    >
        <button
            type="button"
            class="language-dropdown-item ar {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
            role="option"
            aria-selected="{{ app()->getLocale() == 'ar' ? 'true' : 'false' }}"
            data-locale="ar"
            tabindex="-1"
        >
            <span class="flag">🇸🇦</span>
            <span>العربية (AR)</span>
            <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </button>
        <button
            type="button"
            class="language-dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
            role="option"
            aria-selected="{{ app()->getLocale() == 'en' ? 'true' : 'false' }}"
            data-locale="en"
            tabindex="-1"
        >
            <span class="flag">🇺🇸</span>
            <span>English (EN)</span>
            <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </button>
    </div>
</div>

<script>
(function() {
    'use strict';

    const dropdownBtn = document.getElementById('languageDropdownBtn');
    const dropdown = document.getElementById('languageDropdown');
    const languageItems = dropdown.querySelectorAll('.language-dropdown-item');
    let isOpen = false;
    let currentFocusIndex = -1;

    // Toggle dropdown visibility
    function toggleDropdown() {
        isOpen = !isOpen;
        dropdown.classList.toggle('show', isOpen);
        dropdownBtn.setAttribute('aria-expanded', isOpen.toString());

        if (isOpen) {
            // Focus the first item or the active item
            const activeItem = dropdown.querySelector('.language-dropdown-item.active');
            currentFocusIndex = activeItem ? Array.from(languageItems).indexOf(activeItem) : 0;
            focusItem(currentFocusIndex);
        } else {
            dropdownBtn.focus();
            currentFocusIndex = -1;
        }
    }

    // Close dropdown
    function closeDropdown() {
        isOpen = false;
        dropdown.classList.remove('show');
        dropdownBtn.setAttribute('aria-expanded', 'false');
        currentFocusIndex = -1;
    }

    // Focus a specific item
    function focusItem(index) {
        languageItems.forEach((item, i) => {
            item.tabIndex = i === index ? 0 : -1;
            if (i === index) {
                item.focus();
            }
        });
    }

    // Move focus to next/previous item
    function moveFocus(direction) {
        if (!isOpen) return;

        if (direction === 'next') {
            currentFocusIndex = (currentFocusIndex + 1) % languageItems.length;
        } else {
            currentFocusIndex = (currentFocusIndex - 1 + languageItems.length) % languageItems.length;
        }
        focusItem(currentFocusIndex);
    }

    // Switch language
    function switchLanguage(locale, redirect = true) {
        console.log('switchLanguage called with:', locale);

        if (redirect) {
            console.log('Redirecting to:', `/language/${locale}`);
            // Navigate to language switch route - let the server handle cookie and session
            window.location.href = `/language/${locale}`;
        }
    }

    // Event listeners
    dropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleDropdown();
    });

    // Keyboard navigation
    dropdownBtn.addEventListener('keydown', function(e) {
        switch(e.key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                toggleDropdown();
                break;
            case 'ArrowDown':
                e.preventDefault();
                if (!isOpen) toggleDropdown();
                else moveFocus('next');
                break;
            case 'ArrowUp':
                e.preventDefault();
                if (!isOpen) toggleDropdown();
                else moveFocus('prev');
                break;
            case 'Escape':
                if (isOpen) {
                    e.preventDefault();
                    closeDropdown();
                    dropdownBtn.focus();
                }
                break;
        }
    });

    // Language item click handlers
    languageItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const locale = this.getAttribute('data-locale');
            const currentLocale = '{{ app()->getLocale() }}';
            console.log('Language clicked:', locale, 'Current:', currentLocale);

            if (locale !== currentLocale) {
                console.log('Switching to:', locale);
                switchLanguage(locale);
            } else {
                console.log('Same language, closing dropdown');
                closeDropdown();
            }
        });

        item.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    const locale = this.getAttribute('data-locale');
                    const currentLocale = '{{ app()->getLocale() }}';

                    if (locale !== currentLocale) {
                        switchLanguage(locale);
                    } else {
                        closeDropdown();
                        dropdownBtn.focus();
                    }
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    moveFocus('next');
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    moveFocus('prev');
                    break;
                case 'Escape':
                    e.preventDefault();
                    closeDropdown();
                    dropdownBtn.focus();
                    break;
                case 'Tab':
                    if (e.shiftKey && currentFocusIndex === 0) {
                        // Allow tabbing out at the beginning
                        closeDropdown();
                    } else if (!e.shiftKey && currentFocusIndex === languageItems.length - 1) {
                        // Allow tabbing out at the end
                        closeDropdown();
                    }
                    break;
            }
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdownContainer = document.querySelector('.language-dropdown');
        if (dropdownContainer && !dropdownContainer.contains(event.target) && isOpen) {
            closeDropdown();
        }
    });

    // Close dropdown on window resize (mobile friendly)
    window.addEventListener('resize', function() {
        if (isOpen) {
            closeDropdown();
        }
    });

    // Initialize - no automatic language switching, server handles locale from cookie
})();
</script>
