<?php

namespace Romkamix\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostPing extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'host_ping';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // public function scopeLast($query)
    // {
    //     return $query->where(function ($query) use ($search) {
    //         $query->where('client_number', 'LIKE', "{$search}%")
    //             ->orWhere('client_name', 'LIKE', "%{$search}%")
    //             ->orWhere('client_phone', 'LIKE', "%{$search}%")
    //             ->orWhere('client_mail', 'LIKE', "%{$search}%")
    //             ->orWhere('client_place', 'LIKE', "%{$search}%")
    //             ->orWhere('client_project', 'LIKE', "%{$search}%")
    //             ->orWhere('client_tech', 'LIKE', "%{$search}%");
    //     });
    // }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getSuccessAttribute(): bool
    {
        return (bool) $this->latency;
    }
}
