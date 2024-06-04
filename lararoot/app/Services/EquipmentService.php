<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Сервис для управления оборудованием.
 */
class EquipmentService
{
    /**
     * Проверяет соответствие серийного номера маске
     *
     * @param string $serialNumber Серийный номер оборудования
     * @param string $mask Маска типа оборудования
     * @return bool Возвращает true, если серийный номер соответствует маске, иначе false
     */
    protected function validateSerialNumber(string $serialNumber, string $mask): bool
    {
        $pattern = '/^' . str_replace(
            ['A', 'a', 'N', 'X', 'Z'],
            ['[A-Z]', '[a-z]', '[0-9]', '[A-Z0-9]', '[-_@]'],
            $mask
        ) . '$/';

        return preg_match($pattern, $serialNumber);
    }

    /**
     * Создать новое оборудование.
     *
     * @param array $data Данные для создания нового оборудования.
     * @return array Массив результатов создания оборудования
     */
    public function create(array $data): array
    {
        $results = [];

        foreach ($data as $equipmentData) {
            try {
                $validator = Validator::make($equipmentData, [
                    'equipment_type_id' => 'required|exists:equipment_types,id',
                    'serial_number' => 'required|string',
                    'desc' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $equipmentType = EquipmentType::findOrFail($equipmentData['equipment_type_id']);

                if (!$this->validateSerialNumber($equipmentData['serial_number'], $equipmentType->mask)) {
                    throw ValidationException::withMessages([
                        'serial_number' => "Серийный номер {$equipmentData['serial_number']} не соответствует маске {$equipmentType->mask}",
                    ]);
                }

                // Проверка на существование записи с пометкой о дате удаления
                $existingEquipment = Equipment::withTrashed()
                    ->where('serial_number', $equipmentData['serial_number'])
                    ->where('equipment_type_id', $equipmentData['equipment_type_id'])
                    ->first();

                if ($existingEquipment && !$existingEquipment->trashed()) {
                    throw ValidationException::withMessages([
                        'serial_number' => "Серийный номер {$equipmentData['serial_number']} уже существует для данного типа оборудования",
                    ]);
                }

                // Создание нового оборудования
                $equipment = Equipment::create($equipmentData);
                $results[] = [
                    'success' => true,
                    'message' => "Оборудование с серийным номером {$equipment->serial_number} успешно добавлено",
                ];

            } catch (\Exception $e) {
                $errorMessage = $e instanceof ValidationException ? implode(", ", Arr::flatten($e->errors())) : $e->getMessage();
                $results[] = [
                    'success' => false,
                    'message' => $errorMessage,
                ];
            }
        }

        return $results;
    }

    /**
     * Обновить существующее оборудование.
     *
     * @param Equipment $equipment Экземпляр оборудования для обновления.
     * @param array $data Данные для обновления оборудования.
     * @return Equipment Обновленное оборудование.
     * @throws ValidationException Если валидация данных не проходит.
     *
     * Этот метод валидирует входные данные и обновляет существующую запись оборудования в базе данных.
     */
    public function update(Equipment $equipment, array $data): Equipment
    {
        $validator = Validator::make($data, [
            'equipment_type_id' => 'sometimes|exists:equipment_types,id',
            'serial_number' => 'sometimes|string|unique:equipment,serial_number,' . $equipment->id . ',id,equipment_type_id,' . ($data['equipment_type_id'] ?? $equipment->equipment_type_id),
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (isset($data['serial_number']) && isset($data['equipment_type_id'])) {
            $equipmentType = EquipmentType::find($data['equipment_type_id']);
            if (!$this->validateSerialNumber($data['serial_number'], $equipmentType->mask)) {
                throw ValidationException::withMessages([
                    'serial_number' => "Серийный номер {$data['serial_number']} не соответствует маске {$equipmentType->mask}",
                ]);
            }
        }

        $equipment->update($data);
        return $equipment;
    }
}
