<x-filament-panels::page>
    <div class="space-y-6">
        {{-- فلترة الفترة الزمنية --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    فلترة الفترة الزمنية
                </div>
            </x-slot>
            <x-slot name="description">
                اختر الفترة الزمنية لعرض التحليلات المالية
            </x-slot>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="startDateAnalytics" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">من تاريخ</label>
                    <input type="date" 
                           id="startDateAnalytics" 
                           wire:model.live="startDate" 
                           class="fi-input block w-full rounded-lg border-none bg-white px-3 py-2 text-base text-gray-950 shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-400 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 dark:bg-white/5 dark:text-white dark:placeholder:text-gray-500 dark:ring-white/10 dark:focus:ring-white/20 sm:text-sm sm:leading-6">
                </div>
                <div>
                    <label for="endDateAnalytics" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">إلى تاريخ</label>
                    <input type="date" 
                           id="endDateAnalytics" 
                           wire:model.live="endDate" 
                           class="fi-input block w-full rounded-lg border-none bg-white px-3 py-2 text-base text-gray-950 shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-400 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 dark:bg-white/5 dark:text-white dark:placeholder:text-gray-500 dark:ring-white/10 dark:focus:ring-white/20 sm:text-sm sm:leading-6">
                </div>
                <div>
                    <label for="periodAnalytics" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نوع الفترة</label>
                    <select id="periodAnalytics" 
                            wire:model.live="period" 
                            class="fi-input block w-full rounded-lg border-none bg-white px-3 py-2 text-base text-gray-950 shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-400 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 dark:bg-white/5 dark:text-white dark:placeholder:text-gray-500 dark:ring-white/10 dark:focus:ring-white/20 sm:text-sm sm:leading-6">
                        <option value="month">شهري</option>
                        <option value="week">أسبوعي</option>
                        <option value="year">سنوي</option>
                    </select>
                </div>
            </div>
        </x-filament::section>

        {{-- تحليل الربحية --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    تحليل الربحية
                </div>
            </x-slot>
            @php
                $profitability = $this->getProfitabilityAnalysis();
                $revenuePercent = $profitability['revenue'] > 0 ? 100 : 0;
                $costPercent = $profitability['revenue'] > 0 ? ($profitability['cost'] / $profitability['revenue']) * 100 : 0;
                $profitPercent = $profitability['revenue'] > 0 ? ($profitability['profit'] / $profitability['revenue']) * 100 : 0;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 shadow-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-700 dark:text-blue-300">الإيرادات</span>
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($profitability['revenue'], 2) }}</div>
                    <div class="text-sm text-blue-600 dark:text-blue-400 mt-1">ر.س</div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-6 shadow-lg border border-orange-200 dark:border-orange-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-orange-700 dark:text-orange-300">التكلفة</span>
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-orange-900 dark:text-orange-100">{{ number_format($profitability['cost'], 2) }}</div>
                    <div class="text-sm text-orange-600 dark:text-orange-400 mt-1">ر.س</div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 shadow-lg border border-green-200 dark:border-green-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-green-700 dark:text-green-300">الربح</span>
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-green-900 dark:text-green-100">{{ number_format($profitability['profit'], 2) }}</div>
                    <div class="text-sm text-green-600 dark:text-green-400 mt-1">ر.س</div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-6 shadow-lg border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-purple-700 dark:text-purple-300">هامش الربح</span>
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-purple-900 dark:text-purple-100">{{ number_format($profitability['profit_margin'], 2) }}%</div>
                    <div class="mt-2">
                        <div class="w-full bg-purple-200 dark:bg-purple-800 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min($profitability['profit_margin'], 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>

        {{-- اتجاه الإيرادات --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    اتجاه الإيرادات
                </div>
            </x-slot>
            @php
                $trendData = collect($this->getRevenueTrendData());
                $maxRevenue = $trendData->max('revenue') ?? 1;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6">
                <div class="flex items-end justify-between gap-2 h-64">
                    @foreach($trendData as $item)
                        <div class="flex-1 flex flex-col items-center gap-2">
                            <div class="w-full flex items-end justify-center" style="height: 200px;">
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-indigo-300 dark:from-indigo-600 dark:to-indigo-400 rounded-t-lg transition-all hover:from-indigo-600 hover:to-indigo-400 dark:hover:from-indigo-700 dark:hover:to-indigo-500" 
                                     style="height: {{ $maxRevenue > 0 ? ($item['revenue'] / $maxRevenue) * 100 : 0 }}%; min-height: 2px;"
                                     title="{{ number_format($item['revenue'], 2) }} ر.س">
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400 text-center transform -rotate-45 origin-center whitespace-nowrap" style="writing-mode: vertical-rl; text-orientation: mixed;">
                                {{ $item['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    القيمة القصوى: {{ number_format($maxRevenue, 2) }} ر.س
                </div>
            </div>
        </x-filament::section>

        {{-- أفضل المنتجات ربحية --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    أفضل المنتجات ربحية
                </div>
            </x-slot>
            @php
                $topProducts = $this->getTopProductsByProfit();
                $maxProfit = collect($topProducts)->max('profit') ?? 1;
            @endphp
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">المنتج</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">الكمية</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">الإيرادات</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">التكلفة</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">الربح</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">هامش الربح</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">النسبة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($topProducts as $index => $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center gap-2">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    {{ $product['product_name'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ number_format($product['quantity']) }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ number_format($product['revenue'], 2) }} ر.س</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ number_format($product['cost'], 2) }} ر.س</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-green-600 dark:text-green-400">{{ number_format($product['profit'], 2) }} ر.س</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product['profit_margin'] >= 20 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($product['profit_margin'] >= 10 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                    {{ number_format($product['profit_margin'], 2) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 min-w-[100px]">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2.5 rounded-full" 
                                         style="width: {{ $maxProfit > 0 ? ($product['profit'] / $maxProfit) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="mt-2">لا توجد بيانات لعرضها</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- معدل النمو --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    معدل النمو
                </div>
            </x-slot>
            @php
                $growth = $this->getGrowthRate();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 shadow-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-3 bg-blue-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-blue-700 dark:text-blue-300">الفترة الحالية</div>
                            <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($growth['current'], 2) }} ر.س</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/20 dark:to-gray-700/20 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-3 bg-gray-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">الفترة السابقة</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($growth['previous'], 2) }} ر.س</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br {{ $growth['growth_rate'] >= 0 ? 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-green-200 dark:border-green-800' : 'from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-red-200 dark:border-red-800' }} rounded-xl p-6 shadow-lg border">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-3 {{ $growth['growth_rate'] >= 0 ? 'bg-green-500' : 'bg-red-500' }} rounded-lg">
                            @if($growth['growth_rate'] >= 0)
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm font-medium {{ $growth['growth_rate'] >= 0 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">معدل النمو</div>
                            <div class="text-2xl font-bold {{ $growth['growth_rate'] >= 0 ? 'text-green-900 dark:text-green-100' : 'text-red-900 dark:text-red-100' }}">
                                {{ $growth['growth_rate'] >= 0 ? '+' : '' }}{{ number_format($growth['growth_rate'], 2) }}%
                            </div>
                        </div>
                    </div>
                    @if($growth['growth_rate'] != 0)
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="{{ $growth['growth_rate'] >= 0 ? 'bg-green-500' : 'bg-red-500' }} h-2 rounded-full" 
                                 style="width: {{ min(abs($growth['growth_rate']), 100) }}%">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
