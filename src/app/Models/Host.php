<?php

namespace Romkamix\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JJG\Ping;

class Host extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'hosts';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function ping($method = 'fsockopen'): HostPing
    {
        $ping = new Ping($this->host);

        if ($this->port) {
            $ping->setPort($this->port);
        }

        return $this->pings()->create([
            'latency' =>  (int) $ping->ping($method),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pings(): HasMany
    {
        return $this->hasMany(HostPing::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOfUser(Builder $query, User $user)
    {
        return $query->where('user_id',  $user->id);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getLastPingAttribute(): ?HostPing
    {
        return $this->pings()
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
