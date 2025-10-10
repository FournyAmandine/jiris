<?php

namespace App\Models;

use App\Enums\ContactRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Homework extends Model
{
    protected $table = 'homeworks';

    public function projects():HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function contacts():BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'implementations');
    }
    public function evaluated():BelongsToMany
    {
        return $this->contacts()->wherePivot('role', ContactRoles::Evaluated);
    }

    public function jiris():HasMany
    {
        return $this->hasMany(Jiri::class);
    }

    public function implementations():HasMany
    {
        return $this->hasMany(Implementation::class);
    }
}
