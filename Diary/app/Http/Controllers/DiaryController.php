<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;
//require_once(’別のファイル’)の進化版

class DiaryController extends Controller
{
    public function index(){
        // dd('hello Laravel');
        //dump and die関数という Laravelに用意された関数
        //var_dumpとdieを組み合わせたもの
        //Laravel開発の必須ツールです。

        //モデルファイルを使ってデータを取得する
        $diaries = Diary::with('likes')->orderby('id','besc')->get();
        //select * From diaries WEHERE 1 を実行し$diariesに入れる
        //all()メソッド
        //colectionをarrayに変換するtoarray()メソッドをチェインする
        // dd($diaries);

        return view('diaries.index',['diaries'=> $diaries]);
        //view関数はresorses/views/ないいにあるファイルを取得する関数
        //veiw('ファイル名’)もしくは
        //view(フォルダ名、ファイル名)のように記述する
        //ex) views('welcome')
        //ex) views('diaries.edit')
        //*ファイル名は.bladeの前のみ
    }
    public function create(){
        //投稿画面
        return view('diaries.create');
    }

    public function store(CreateDiary $request){
       //保存処理
        //POST送信データの受け取り
        // dd('porkbelly');確認
        //$_POSTの代わりにrequest クラスを使用する
        // dd($request);確認
        
        //INERT INTO テーブル名 (カラム名) VALUE(値)
         //INERT INTO diaries (title,body) VALUE ($_POST['title'],$_POST['body'])
          //INERT INTO diaries (title,body) VALUE ($request->title,$_POST['body'])

        $diary =   new Diary();//インスタンス化
        $diary->title = $request->title;
        $diary->body = $request->body;
        $diary->user_id = Auth::user()->id;
        // dd(Auth::user);
        //ランダムな文字名を設定
        //選択された画像をstorge/app/public/diary_img/にアップロード
        //画像名を返す
        $diary->img_url = $request->img_url->store('public/diary_img');
        //storeAsで画像をアップロードしてくれる アップロードするフォルダの場所、ファイルを後にかく
        //storeと書くこともできる、他と被らなくなるようにできる、画像が
        $diary->save();

        //一覧ページに戻る（リダイレクト処理）
        return redirect()->route('diary.index');//header()と同じような処理


    }
    public function destroy($id){
        
        // dd($id);
        
        $diariesに入れるy = Diary::find($id);
        //DELETE * FROM diaries WHERE id=?

        $diary->delete();
       //DERETE FROM テーブル名 WHERE id=?
        return redirect()->route('diary.index');
    }
    function edit($id){
        $diary= Diary::find($id);
        //SELECT * FROM diaries WHERE id=?
        //diaryはcollectionという型でできている、arrayに変換するにはtoarray()

        return view('diaries.edit',['diary' => $diary]);
    }
    function update($id,CreateDiary $request){
        $diary= Diary::find($id); //一件データ取得
        
        $diary->title = $request->title;//値上書き
        $diary->body = $request->body;//値上書き
        $diary->save(); //保存

          return redirect()->route('diary.index');
    }

    function mypage(){
        //パターン１
        // $login_user = Auth::user();
        // // dd($login_user->id);
        // $diaries = Diary::where('user_id', 1)->get();
        // //where('カラム名',値）;
        // //select * from diaries where カラム名=値
        // dd($diaries);
        
        //Modelのリレーションを使ったパターン
        $login_user = Auth::user();
        $diaries = $login_user->diaries;

        
        return view('diaries.mypage',['diaries' => $diaries]);
    }
    function like($id){
        $diary = Diary::where('id',$id)->with('likes')->first();

        //likesテーブルに選択されている$diaryとログインしているユーザーのidをInsertする
        $diary->likes()->attach(Auth::user()->id);
        // Insert into likes (diary_id,user_id) Valuesn($diary->id, Auth::user()->id)

        return redirect()->route('diary.index');
    }

    function dislike($id){
        $diary = Diary::where('id, $id')->with('likes')->first();//with(likes)でdiaryに紐ずいてい良いねをテーブルから引っ張ってくる
        //SELECT * from diaries Join likes //joinと同じことをwithでしてる
        $diary->likes()->detach(Auth::user()->id);
        //DELETE FROM likes WHERE diary_id=diary->id AND user id_Auth::user()->id
        return redirect()->route('diary.index');
    }
         
    
}

