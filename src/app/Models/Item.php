<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sellIn', 'quality', 'imgUrl'];

    protected $attributes = [
        'img_url' => '',
    ];

    protected $casts = [
        'sellIn' => 'integer',
        'quality' => 'integer',
    ];

    public function __toString(): string
    {
        return (string) "{$this->name}, {$this->sellIn}, {$this->quality}";
    }
    public function getImgUrlAttribute(): string
    {
        return $this->attributes['img_url'];
    }

    public function setImgUrlAttribute(string $imgUrl): void
    {
        $this->attributes['img_url'] = $imgUrl;
    }
}
