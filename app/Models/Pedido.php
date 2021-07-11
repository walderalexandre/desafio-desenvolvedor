<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    public function pedidoDetalhes()
    {
        return $this->hasMany('App\PedidoDetalhe');
    } 

    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class);
    }

}
