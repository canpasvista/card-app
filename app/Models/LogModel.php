<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    use HasFactory;
    protected $table = "logs";
    protected $fillable = ["who","message"];
    public static function add($who,$message){
        LogModel::create(
            [
                "who" => $who,
                "message" => $message
            ]
            );
    }
    
}
