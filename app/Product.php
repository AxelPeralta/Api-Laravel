<?php

namespace App;
use App\Category;
use App\Seller;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Constantes para colocar el status de un producto
    const PRODUCTO_DISPONIBLE='disponible';
    const PRODUCTO_NO_DISPONIBLE='no disponible';

    protected $fillable =[
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden = [
        'pivot',
    ];

    // Funcion para verifar si un producto esta disponible
    public function estaDisponible(){
        return $this-> status == Product::PRODUCTO_DISPONIBLE;
    }

    //relacion indicanto de un producto pretenece a un venedor

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    //relacion de un producto a muchas transacciones 
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    //relacion muchos a muchos con categorias

    public function Categories(){
        return $this->belongsToMany(Category::class);
    }
}
