<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'table_name',
        'record_id',
        'action',
        'old_values',
        'new_values',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Get the user that performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted action name
     */
    public function getFormattedActionAttribute(): string
    {
        return match ($this->action) {
            'INSERT' => 'Dibuat',
            'UPDATE' => 'Diperbarui',
            'DELETE' => 'Dihapus',
            default => $this->action,
        };
    }

    /**
     * Get formatted table name
     */
    public function getFormattedTableNameAttribute(): string
    {
        return match ($this->table_name) {
            'siswas' => 'Siswa',
            'pkls' => 'PKL',
            'industris' => 'Industri',
            'gurus' => 'Guru',
            'users' => 'User',
            default => ucfirst($this->table_name),
        };
    }

    /**
     * Get changes summary
     */
    public function getChangesSummaryAttribute(): array
    {
        if ($this->action === 'INSERT') {
            return $this->new_values ?? [];
        }

        if ($this->action === 'DELETE') {
            return $this->old_values ?? [];
        }

        if ($this->action === 'UPDATE' && $this->old_values && $this->new_values) {
            $changes = [];
            foreach ($this->new_values as $key => $newValue) {
                $oldValue = $this->old_values[$key] ?? null;
                if ($oldValue !== $newValue) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                }
            }
            return $changes;
        }

        return [];
    }

    /**
     * Scope untuk filter berdasarkan tabel
     */
    public function scopeForTable($query, string $tableName)
    {
        return $query->where('table_name', $tableName);
    }

    /**
     * Scope untuk filter berdasarkan record
     */
    public function scopeForRecord($query, string $tableName, int $recordId)
    {
        return $query->where('table_name', $tableName)
                    ->where('record_id', $recordId);
    }

    /**
     * Scope untuk filter berdasarkan action
     */
    public function scopeForAction($query, string $action)
    {
        return $query->where('action', strtoupper($action));
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}