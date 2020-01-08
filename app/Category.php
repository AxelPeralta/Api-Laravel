<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Product;
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'pivot',
    ];
    // relacion mucho a muchos con productos

    public function Products()
    {
        return $this->belongsToMany(Product::class);
    }
}
