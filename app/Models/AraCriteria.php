<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AraCriteria extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_criteria';
    protected $fillable = ['criteria', 'attribute', 'weight'];

    public function evaluation(): HasMany
    {
        return $this->hasMany(AraEvaluation::class, 'id', 'id_criteria');
    }
}