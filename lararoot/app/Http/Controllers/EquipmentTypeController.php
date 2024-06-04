<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListEquipmentTypeRequest;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

/**
 * Контроллер для управления типами оборудования.
 */
class EquipmentTypeController extends Controller
{
    /**
     * Получить список типов оборудования.
     *
     * @param ListEquipmentTypeRequest $request Запрос для получения списка типов оборудования
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция ресурсов типов оборудования
     */
    public function index(ListEquipmentTypeRequest $request)
    {
        $query = EquipmentType::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('mask', 'like', '%' . $request->q . '%');
        } elseif ($request->has('mask')) {
            $query->where('mask', 'like', '%' . $request->mask . '%');
        } elseif ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $equipmentTypes = $query->paginate();
        return EquipmentTypeResource::collection($equipmentTypes);
    }

    /**
     * Показать информацию о конкретном типе оборудования.
     *
     * @param EquipmentType $equipmentType Модель типа оборудования
     * @return EquipmentTypeResource Ресурс типа оборудования
     */
    public function show(EquipmentType $equipmentType)
    {
        return new EquipmentTypeResource($equipmentType);
    }

    /**
     * Создать новый тип оборудования.
     *
     * @param Request $request Запрос с данными для создания типа оборудования.
     * @return EquipmentTypeResource Созданный ресурс типа оборудования.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'mask' => 'required|string|max:255',
        ]);

        $equipmentType = EquipmentType::create($data);
        return new EquipmentTypeResource($equipmentType);
    }

    /**
     * Обновить информацию о конкретном типе оборудования.
     *
     * @param Request $request Запрос на обновление типа оборудования
     * @param EquipmentType $equipmentType Модель типа оборудования
     * @return EquipmentTypeResource Ресурс обновлённого типа оборудования
     */
    public function update(Request $request, EquipmentType $equipmentType)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'mask' => 'sometimes|required|string|max:255',
        ]);

        $equipmentType->update($data);
        return new EquipmentTypeResource($equipmentType);
    }

    /**
     * Удалить конкретный тип оборудования.
     *
     * @param EquipmentType $equipmentType Модель типа оборудования
     * @return \Illuminate\Http\Response Ответ без содержания.
     */
    public function destroy(EquipmentType $equipmentType)
    {
        $equipmentType->delete();
        return response()->noContent();
    }
}
