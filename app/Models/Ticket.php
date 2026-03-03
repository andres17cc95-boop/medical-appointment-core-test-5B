<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    /** Estados posibles del ticket */
    public const STATUS_ABIERTO = 'abierto';
    public const STATUS_EN_PROCESO = 'en_proceso';
    public const STATUS_CERRADO = 'cerrado';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** Usuario que creó el ticket */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Etiqueta legible del estado */
    public static function statusLabel(string $status): string
    {
        return match ($status) {
            self::STATUS_ABIERTO => 'Abierto',
            self::STATUS_EN_PROCESO => 'En proceso',
            self::STATUS_CERRADO => 'Cerrado',
            default => $status,
        };
    }

    /** Clases CSS para el badge de estado (estilo Flowbite) */
    public static function statusBadgeClass(string $status): string
    {
        return match ($status) {
            self::STATUS_ABIERTO => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            self::STATUS_EN_PROCESO => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::STATUS_CERRADO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        };
    }
}
