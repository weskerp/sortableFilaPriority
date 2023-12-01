<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $table = 'processos';
    protected $fillable = [
        'cod', 
        'name', 
        'prox',
        'ant',
        'updated_at',
    ];

}
