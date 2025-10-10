<?php

namespace App\Models;

use App\Enums\ContactRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Implementation extends Model
{
    public $timestamps = false;

    public function contacts():HasMany
    {
        return $this->hasMany(Homework::class);
    }

    public function evaluated():HasMany
    {
        return $this->contacts()->wherePivot('role', ContactRoles::Evaluated);
    }

    public function homeworks():HasMany
    {
        return $this->hasMany(Homework::class);
    }
}
