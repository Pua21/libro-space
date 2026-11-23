<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'tipe_data',
        'keterangan',
        'updated_by',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Helper to get setting value by key with optional default
     */
    public static function getVal(string $key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();
        if (!$setting) return $default;

        return match ($setting->tipe_data) {
            'integer' => (int) $setting->setting_value,
            'decimal' => (float) $setting->setting_value,
            'boolean' => filter_var($setting->setting_value, FILTER_VALIDATE_BOOLEAN),
            default => $setting->setting_value,
        };
    }
}
