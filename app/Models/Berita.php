<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    protected $guarded = ['id'];

    protected function aktif(Builder $query): void
    {
        $query->where('active', 1);
    }
}
