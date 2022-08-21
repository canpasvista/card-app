<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class configModel extends Model
{
    use HasFactory;
    protected $table = "config";
    protected $fillable = ["last_game_id"];
    /**
     * 
     * 最後に開催しているgame_idを返却
     * 
     * @return int last_game_id
     */
    public function getLastGameId(){
        $item = configModel::find(1);
        return $item->last_game_id;
    }
    /**
     * 
     * game_idを１加算し、そのgame_idを返却
     * 
     * @return int game_id
     */
    public function setNewLastGameId(){

        DB::beginTransaction();
        try {
            $item = configModel::lockForUpdate()->find(1);
            $item->last_game_id = $item->last_game_id +1;
            $item->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $item->last_game_id;
    }
}
