<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления оборудования.
 */
class EquipmentResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив.
     *
     * @param Request $request HTTP-запрос.
     * @return array<string, mixed> Массив, представляющий ресурс оборудования.
     * 
     * Этот метод используется для преобразования ресурса оборудования в массив.
     * Он возвращает массив, содержащий данные об оборудовании, такие как идентификатор,
     * тип оборудования, серийный номер, описание, а также даты создания и обновления.
     * Для связи с типом оборудования используется ресурс `EquipmentTypeResource`.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipment_type' => new EquipmentTypeResource($this->whenLoaded('equipmentType')),
            'serial_number' => $this->serial_number,
            'desc' => $this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
