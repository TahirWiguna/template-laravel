<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiContent extends Model
{
    use HasFactory;

    protected $table = 'wiki_contents';

    protected $fillable = [
        'wiki_header_id',
        'slug',
        'judul',
        'isi',
    ];

    public function header()
    {
        return $this->belongsTo(WikiHeader::class);
    }
}
