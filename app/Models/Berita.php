<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
