<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-filament::section>
                <x-slot name="heading">
                    متوسط قيمة الطلب
                </x-slot>
                <div class="text-3xl font-bold text-center py-4">
                    {{ number_format($this->getAverageOrderValue(), 2) }} ر.س
                </div>
                <div class="text-sm text-gray-600 text-center">آخر 30 يوم</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    متوسط هامش الربح
                </x-slot>
                <div class="text-3xl font-bold text-center py-4 text-blue-600">
                    {{ number_format($this->getAverageProfitMargin(), 2) }}%
                </div>
                <div class="text-sm text-gray-600 text-center">آخر 30 يوم</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    معدل النمو
                </x-slot>
                <div class="text-3xl font-bold text-center py-4 {{ $this->getGrowthRate() >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($this->getGrowthRate(), 2) }}%
                </div>
                <div class="text-sm text-gray-600 text-center">مقارنة بالشهر السابق</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    معدل دوران المخزون
                </x-slot>
                <div class="text-3xl font-bold text-center py-4">
                    {{ number_format($this->getInventoryTurnover(), 2) }}
                </div>
                <div class="text-sm text-gray-600 text-center">آخر 12 شهر</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    معدل العائد على الاستثمار (ROI)
                </x-slot>
                <div class="text-3xl font-bold text-center py-4 text-green-600">
                    {{ number_format($this->getROI(), 2) }}%
                </div>
                <div class="text-sm text-gray-600 text-center">آخر 12 شهر</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    قيمة العميل مدى الحياة
                </x-slot>
                <div class="text-3xl font-bold text-center py-4">
                    {{ number_format($this->getCustomerLifetimeValue(), 2) }} ر.س
                </div>
                <div class="text-sm text-gray-600 text-center">متوسط القيمة</div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    معدل التحويل
                </x-slot>
                <div class="text-3xl font-bold text-center py-4 text-blue-600">
                    {{ number_format($this->getConversionRate(), 2) }}%
                </div>
                <div class="text-sm text-gray-600 text-center">نسبة الطلبات المكتملة</div>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
