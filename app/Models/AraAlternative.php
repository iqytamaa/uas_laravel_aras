<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AraAlternative extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alternative';
    protected $fillable = ['name'];

    public function evaluation(): HasMany
    {
        return $this->hasMany(AraEvaluation::class, 'id', 'id_alternative');
    }
}
