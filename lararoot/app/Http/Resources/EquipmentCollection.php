<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Коллекция ресурсов для оборудования.
 */
class EquipmentCollection extends ResourceCollection
{
    /**
     * Преобразовать коллекцию ресурсов в массив.
     *
     * @param Request $request HTTP-запрос.
     * @return array<int|string, mixed> Массив, представляющий коллекцию ресурсов.
     * 
     * Этот метод используется для преобразования коллекции ресурсов оборудования в массив.
     * Он вызывает родительский метод `toArray`, который автоматически преобразует
     * коллекцию моделей в соответствующий массив с учетом правил сериализации.
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
