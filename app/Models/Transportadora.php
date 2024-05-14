<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    use HasFactory;

    protected $table = 'transportadoras';

    protected $fillable = [
        'uuid',
        'nome',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'limite_credito',
        'data_analise_credito'
    ];

    /**
     * Formata a data de análise de crédito
     *
     * @param [type] $value
     * @return void
     */
    public function getDataAnaliseCreditoAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->diffForHumans() : null;
    }

    /**
     * Formata o limite de crédito
     *
     * @param [type] $value
     * @return void
     */
    public function getLimiteCreditoAttribute($value)
    {
        return $value ? 'R$'.number_format($value, 2, ',', '.') : null;
    }
}
