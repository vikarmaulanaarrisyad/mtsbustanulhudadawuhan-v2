<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    protected $guarded = ['id'];
    protected $table = 'halamans';

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
