<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Models\historyModel;
use App\Models\toukei\toukei1Model;
use App\Models\toukei\toukei2Model;
use App\Services\gameService;

class toukeiController extends Controller
{
    /**
     * 統計履歴の表示
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function index(
    )
    {
        $toukei1 = toukei1Model::limit(13)->get();
        $toukei2 = toukei2Model::all();
        return view('toukei',compact('toukei1','toukei2'));
    }
}
