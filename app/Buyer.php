<?php

namespace App;
use App\transaction;

class Buyer extends User
{
    //relacion en la base de datos
    // un comprador tiene muchas transacciones
    // 1 a muchos 
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
