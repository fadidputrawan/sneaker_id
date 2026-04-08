<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class Product extends Model
{
    protected $fillable = ['nama', 'harga', 'stok', 'brand', 'images', 'deskripsi', 'stok_39', 'stok_40', 'stok_41', 'stok_42', 'stok_43', 'stok_44'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',  // Automatically cast JSON to array
    ];

    /**
     * Get the first image from the images array
     */
    public function getFirstImageAttribute()
    {
        $images = $this->images ?? [];
        return !empty($images) ? $images[0] : null;
    }

    /**
     * Get all images as array
     */
    public function getImagesArrayAttribute()
    {
        if (is_array($this->images)) {
            return $this->images;
        }
        return json_decode($this->images ?? '[]', true) ?: [];
    }

    /**
     * Get stock for a specific size
     */
    public function getStockForSize($size)
    {
        $columnName = 'stok_' . $size;
        return $this->$columnName ?? 0;
    }

    /**
     * Get all size stocks as array
     */
    public function getAllSizeStocks()
    {
        return [
            39 => $this->stok_39 ?? 0,
            40 => $this->stok_40 ?? 0,
            41 => $this->stok_41 ?? 0,
            42 => $this->stok_42 ?? 0,
            43 => $this->stok_43 ?? 0,
            44 => $this->stok_44 ?? 0,
        ];
    }
}

