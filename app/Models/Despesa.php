<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\TipoDespesa;

class Despesa extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_despesa_id', 'valor', 'data_vencimento'];

    public function tipoDespesa()
    {
        return $this->belongsTo(TipoDespesa::class);
    }
}
