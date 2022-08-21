<?php

namespace App\Models\toukei;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class toukei2Model extends Model
{
    use HasFactory;
    protected $table = "toukei2";
    protected $fillable = ["no","use","win","perwin"];
    public static function add($no, $point)
    {
        DB::beginTransaction();
        try {
            $model = toukei2Model::lockForUpdate()->where("no", $no)->first();
            $model->use = $model->use + 1;
            if ($point == 1) {
                $model->win++;
            }
            $model->perwin = $model->win / $model->use;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
