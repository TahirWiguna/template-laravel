<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiHeader extends Model
{
    use HasFactory;

    protected $table = 'wiki_headers';

    protected $fillable = [
        'versi',
        'keterangan',
    ];

    public function contents()
    {
        return $this->hasMany(WikiContent::class);
    }

}
