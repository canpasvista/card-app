<?php

namespace App\Models\toukei;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class toukei1Model extends Model
{
    use HasFactory;
    protected $table = "toukei1";
    protected $fillable = ["time","cnt"];

    /**
     * 統計情報の追加
     */
    public static function add($time0, $time1)
    {
        $time      = ($time0->diffInSeconds($time1));
        $time      = $time - ($time % 10);

        DB::beginTransaction();
        try {
            $model     = toukei1Model::lockForUpdate()->where("time", $time)->first();
            $model->cnt=$model->cnt+1;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
