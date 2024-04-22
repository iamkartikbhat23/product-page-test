<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','price','slug','active'] ;

    public function getNameAttribute($value) {
        return Str::ucfirst($value) ;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->latest()->take(4);
    }

    public function discount()
    {
        return $this->hasOne(ProductDiscount::class);
    }
}
