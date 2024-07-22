<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AraEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['id_alternative', 'id_criteria', 'value'];

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(AraAlternative::class, 'id_alternative');
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(AraCriteria::class, 'id_criteria');
    }
}
