<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-filament::section>
                <x-slot name="heading">
                    فلترة التقارير
                </x-slot>
                <x-slot name="description">
                    اختر الفترة الزمنية لعرض التقارير
                </x-slot>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">من تاريخ</label>
                        <input type="date" wire:model.live="startDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">إلى تاريخ</label>
                        <input type="date" wire:model.live="endDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    ملخص المبيعات
                </x-slot>
                @php
                    $salesData = $this->getSalesReportData();
                @endphp
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>إجمالي الإيرادات:</span>
                        <span class="font-bold">{{ number_format($salesData['total_revenue'], 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between">
                        <span>عدد الطلبات:</span>
                        <span class="font-bold">{{ $salesData['total_orders'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>عدد العناصر:</span>
                        <span class="font-bold">{{ $salesData['total_items'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>متوسط قيمة الطلب:</span>
                        <span class="font-bold">{{ number_format($salesData['avg_order_value'], 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between">
                        <span>إجمالي الضريبة:</span>
                        <span class="font-bold">{{ number_format($salesData['total_tax'], 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between">
                        <span>إجمالي الشحن:</span>
                        <span class="font-bold">{{ number_format($salesData['total_shipping'], 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between">
                        <span>إجمالي الخصومات:</span>
                        <span class="font-bold">{{ number_format($salesData['total_discount'], 2) }} ر.س</span>
                    </div>
                </div>
            </x-filament::section>
        </div>

        <x-filament::section>
            <x-slot name="heading">
                أفضل المنتجات مبيعاً
            </x-slot>
            @php
                $products = $this->getProductReportData();
            @endphp
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-right p-2">المنتج</th>
                            <th class="text-right p-2">الكمية</th>
                            <th class="text-right p-2">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b">
                            <td class="p-2">{{ $product['product_name'] }}</td>
                            <td class="p-2">{{ $product['total_quantity'] }}</td>
                            <td class="p-2">{{ number_format($product['total_revenue'], 2) }} ر.س</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                المبيعات حسب الفئة
            </x-slot>
            @php
                $categories = $this->getCategoryReportData();
            @endphp
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-right p-2">الفئة</th>
                            <th class="text-right p-2">الكمية</th>
                            <th class="text-right p-2">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr class="border-b">
                            <td class="p-2">{{ $category['name'] }}</td>
                            <td class="p-2">{{ $category['total_quantity'] }}</td>
                            <td class="p-2">{{ number_format($category['total_revenue'], 2) }} ر.س</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
