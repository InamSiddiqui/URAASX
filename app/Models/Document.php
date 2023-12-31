<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'orignal_name',
        'path',
        'user_id',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}