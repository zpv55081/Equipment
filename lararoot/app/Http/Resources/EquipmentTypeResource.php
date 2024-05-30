<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для представления типа оборудования.
 */
class EquipmentTypeResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив.
     *
     * @param Request $request HTTP-запрос.
     * @return array<string, mixed> Массив, представляющий ресурс типа оборудования.
     * 
     * Этот метод используется для преобразования ресурса типа оборудования в массив.
     * Он возвращает массив, содержащий данные о типе оборудования, такие как идентификатор,
     * название, маска, а также даты создания и обновления.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mask' => $this->mask,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
