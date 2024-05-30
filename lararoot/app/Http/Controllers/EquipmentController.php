<?php

namespace App\Http\Controllers;

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
     * @param Request $request Запрос с параметрами фильтрации.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция ресурсов оборудования.
     */
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->has('q')) {
            $query->where('serial_number', 'like', '%' . $request->q . '%')
                  ->orWhere('desc', 'like', '%' . $request->q . '%');
        }

        $equipments = $query->paginate();
        return EquipmentResource::collection($equipments);
    }

    /**
     * Показать информацию о конкретном оборудовании.
     *
     * @param int $id Идентификатор оборудования.
     * @return EquipmentResource Ресурс оборудования.
     */
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return new EquipmentResource($equipment);
    }

    /**
     * Создать новое оборудование.
     *
     * @param StoreEquipmentRequest $request Запрос с данными для создания оборудования.
     * @return EquipmentResource Созданный ресурс оборудования.
     */
    public function store(StoreEquipmentRequest $request)
    {
        $data = $request->validated();

        $equipment = $this->equipmentService->create($data);

        return new EquipmentResource($equipment);
    }

    /**
     * Обновить информацию о конкретном оборудовании.
     *
     * @param UpdateEquipmentRequest $request Запрос с данными для обновления оборудования.
     * @param int $id Идентификатор оборудования.
     * @return EquipmentResource Обновленный ресурс оборудования.
     */
    public function update(UpdateEquipmentRequest $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $data = $request->validated();

        $updatedEquipment = $this->equipmentService->update($equipment, $data);

        return new EquipmentResource($updatedEquipment);
    }

    /**
     * Удалить конкретное оборудование.
     *
     * @param int $id Идентификатор оборудования.
     * @return \Illuminate\Http\Response Ответ без содержания.
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return response()->noContent();
    }
}
