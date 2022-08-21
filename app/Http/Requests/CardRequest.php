<?php

namespace App\Http\Requests;

use App\Models\gameModel;
use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'game_id'   => 'required|integer',
            'card'      => 'required|integer',
        ];
    }

    public function makeGame(): gameModel
    {
        // バリデーションした値で埋めた Post を取得
        return new cardModel($this->validated());
    }
}