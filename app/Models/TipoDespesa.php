<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDespesa extends Model
{
    use HasFactory;

    protected $fillable = ['nome_despesa', 'id_usuario']; 

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

}
