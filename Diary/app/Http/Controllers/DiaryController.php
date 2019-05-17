<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once(’別のファイル’)の進化版

class DiaryController extends Controller
{
    public function index(){
        // dd('hello Laravel');
        //dump and die関数という Laravelに用意された関数
        //var_dumpとdieを組み合わせたもの
        //Laravel開発の必須ツールです。

        return view('diaries.index');
        //view関数はresorses/views/ないいにあるファイルを取得する関数
        //veiw('ファイル名’)もしくは
        //view(フォルダ名、ファイル名)のように記述する
        //ex) views('welcome')
        //ex) views('diaries.edit')
        //*ファイル名は.bladeの前のみ
    }
    public function create(){
        return view('diaries.create');
    }
}
