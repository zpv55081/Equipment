<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель для таблицы equipment.
 *
 * @property int $id
 * @property int $equipment_type_id
 * @property string $serial_number
 * @property string $desc
 */
class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipments';

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = ['equipment_type_id', 'serial_number', 'desc'];

    /**
     * Получить тип оборудования, к которому принадлежит это оборудование.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
