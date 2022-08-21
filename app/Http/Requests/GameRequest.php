<?php

namespace App\Http\Requests;

use App\Models\gameModel;
use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'game_id' => 'required|integer',
        ];
    }

    public function makeGame(): gameModel
    {
        $dat = $this->validated();
        // gameModel を取得
        return gameModel::find($dat['game_id']);
    }
}