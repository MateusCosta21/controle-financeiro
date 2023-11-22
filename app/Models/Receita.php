<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\TipoReceita;

class Receita extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_receita_id', 'valor_recebido', 'data_entrada', 'id_usuario'];

    public function tipoReceita()
    {
        return $this->belongsTo(TipoReceita::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
