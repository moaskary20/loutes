<?php

namespace App\Filament\Resources\ShippingMethodResource\Pages;

use App\Filament\Resources\ShippingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShippingMethod extends EditRecord
{
    protected static string $resource = ShippingMethodResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // تحميل بيانات المحافظات من pivot table
        $provinceCosts = [];
        foreach ($this->record->provinces as $province) {
            $provinceCosts[] = [
                'province_id' => $province->id,
                'cost' => $province->pivot->cost,
            ];
        }
        $data['province_costs'] = $provinceCosts;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // استخراج بيانات المحافظات قبل الحفظ
        $provinceCosts = $data['province_costs'] ?? [];
        unset($data['province_costs']);

        // حفظ بيانات المحافظات مؤقتاً
        $this->provinceCosts = $provinceCosts;

        return $data;
    }

    protected function afterSave(): void
    {
        // تحديث ربط المحافظات بطريقة الشحن
        if (isset($this->provinceCosts) && is_array($this->provinceCosts)) {
            // حذف جميع الروابط القديمة
            $this->record->provinces()->detach();

            // إضافة الروابط الجديدة
            foreach ($this->provinceCosts as $provinceCost) {
                if (isset($provinceCost['province_id']) && isset($provinceCost['cost'])) {
                    $this->record->provinces()->attach($provinceCost['province_id'], [
                        'cost' => $provinceCost['cost'],
                    ]);
                }
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected ?array $provinceCosts = null;
}
