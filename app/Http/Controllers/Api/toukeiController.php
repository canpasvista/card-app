<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\historyModel;
use App\Services\gameService;
use App\Models\toukei\toukei1Model;
use App\Models\toukei\toukei2Model;
use App\Http\Requests\GameRequest;

class toukeiController extends Controller
{
    /**
     * 履歴の削除
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function index(
    )
    {
        $toukei2 = toukei2Model::all();
        $toukei1 = toukei1Model::limit(13)->get();
        return view('toukei',compact('toukei1','toukei2'));
    }
}
