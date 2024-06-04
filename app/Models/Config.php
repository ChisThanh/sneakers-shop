<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $primaryKey = 'key';
    protected $fillable = [
        "key",
        "value"
    ];
    public $timestamps = false;
}
