<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function jiris():BelongsToMany
    {
        return $this->belongsToMany(Jiri::class, 'homeworks');
    }

}
