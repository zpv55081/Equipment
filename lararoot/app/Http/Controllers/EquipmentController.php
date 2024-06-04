<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListEquipmentRequest;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

/**
 * Контроллер для управления оборудованием.
 */
class EquipmentController extends Controller
{
    /**
     * Сервис для управления оборудованием.
     *
     * @var EquipmentService
     */
    protected $equipmentService;

    /**
     * Конструктор контроллера.
     *
     * @param EquipmentService $equipmentService Сервис для управления оборудованием.
     */
    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    /**
     * Получить список оборудования.
     * 
     * @param ListEquipmentRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция ресурсов оборудования.
     */
    public function index(ListEquipmentRequest $request)
    {
        $query = Equipment::query();

        if ($request->has('q')) {
            $query->where('serial_number', 'like', '%' . $request->q . '%')
                  ->orWhere('desc', 'like', '%' . $request->q . '%');
        } elseif ($request->has('equipment_type_id')) {
            $query->where('equipment_type_id', $request->equipment_type_id);
        }

        $equipments = $query->with('equipmentType')->paginate();
        return EquipmentResource::collection($equipments);
    }

    /**
     * Создать новое оборудование.
     *
     * @param StoreEquipmentRequest $request Запрос с данными для создания оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEquipmentRequest $request)
    {
        $data = $request->validated();
        $results = $this->equipmentService->create($data['equipments']);
        return response()->json(['results' => $results], 200);
    }

    /**
     * Обновить информацию о конкретном оборудовании.
     *
     * @param UpdateEquipmentRequest $request Запрос с данными для обновления оборудования.
     * @param Equipment $equipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $data = $request->validated();
        $updatedEquipment = $this->equipmentService->update($equipment, $data);
        return response()->json($updatedEquipment);
    }

    /**
     * Удалить конкретное оборудование.
     * 
     * @param Equipment $equipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->json(null, 204);
    }
}
