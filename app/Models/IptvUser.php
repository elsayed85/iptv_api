<?php

namespace App\Models;

use App\Models\Chanel;
use App\Models\Vod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptvUser extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function channels()
    {
        return $this->hasMany(Chanel::class);
    }

    public function vods()
    {
        return $this->hasMany(Vod::class);
    }
}
