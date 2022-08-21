<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cardModel extends Model
{
    use HasFactory;
    protected $table = "cards";
    protected $fillable = ["game_state_id","no","color","sort","user_or_cpu"];
}
