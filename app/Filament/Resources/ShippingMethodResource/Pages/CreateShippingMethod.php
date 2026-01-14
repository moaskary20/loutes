<?php

namespace App\Filament\Resources\ShippingMethodResource\Pages;

use App\Filament\Resources\ShippingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateShippingMethod extends CreateRecord
{
    protected static string $resource = ShippingMethodResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // استخراج بيانات المحافظات قبل الحفظ
        $provinceCosts = $data['province_costs'] ?? [];
        unset($data['province_costs']);

        // حفظ بيانات المحافظات مؤقتاً
        $this->provinceCosts = $provinceCosts;

        return $data;
    }

    protected function afterCreate(): void
    {
        // ربط المحافظات بطريقة الشحن بعد الإنشاء
        if (isset($this->provinceCosts) && is_array($this->provinceCosts)) {
            foreach ($this->provinceCosts as $provinceCost) {
                if (isset($provinceCost['province_id']) && isset($provinceCost['cost'])) {
                    $this->record->provinces()->attach($provinceCost['province_id'], [
                        'cost' => $provinceCost['cost'],
                    ]);
                }
            }
        }
    }

    protected ?array $provinceCosts = null;
}
