<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCollection extends Model
{
    use HasFactory;

    /**
     * Get all of the items for the QrCollection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(QrItem::class, 'collection_id', 'id');
    }
}
