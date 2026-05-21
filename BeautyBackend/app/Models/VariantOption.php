<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantOption extends Model
{
    protected $fillable = ['variant_type_id', 'value', 'hex_color', 'sort_order'];

    public function variantType(): BelongsTo
    {
        return $this->belongsTo(VariantType::class);
    }
}
