<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\TipoDespesa;
Use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Despesa extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['tipo_despesa_id', 'valor', 'data_vencimento', 'id_usuario', 'pago'];

    public function tipoDespesa()
    {
        return $this->belongsTo(TipoDespesa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
