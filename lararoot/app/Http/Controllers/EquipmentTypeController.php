<?php

namespace App\Http\Controllers;

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
     * @param Request $request Запрос с параметрами фильтрации.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция ресурсов типов оборудования.
     */
    public function index(Request $request)
    {
        $query = EquipmentType::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $equipmentTypes = $query->paginate();
        return EquipmentTypeResource::collection($equipmentTypes);
    }

    /**
     * Показать информацию о конкретном типе оборудования.
     *
     * @param int $id Идентификатор типа оборудования.
     * @return EquipmentTypeResource Ресурс типа оборудования.
     */
    public function show($id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
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
     * @param Request $request Запрос с данными для обновления типа оборудования.
     * @param int $id Идентификатор типа оборудования.
     * @return EquipmentTypeResource Обновленный ресурс типа оборудования.
     */
    public function update(Request $request, $id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
        
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
     * @param int $id Идентификатор типа оборудования.
     * @return \Illuminate\Http\Response Ответ без содержания.
     */
    public function destroy($id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
        $equipmentType->delete();

        return response()->noContent();
    }
}
