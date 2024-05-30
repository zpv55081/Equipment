<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для таблицы equipment_type.
 *
 * @property int $id
 * @property string $name
 * @property string $mask
 */
class EquipmentType extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = ['name', 'mask'];
}
