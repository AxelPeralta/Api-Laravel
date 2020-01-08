<?php
use Illuminate\Database\Eloquent\Model;
namespace App;
use App\Product;

class Seller extends User
{
    //un vendedor tien muchos prodcutos
    
    public function products(){
        return $this->hasMany(Product::class);
    }

}
