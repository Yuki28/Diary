@extends('layout')

@section('title')
Diary 一覧
@endsection
{{-- 画像の表示 --}}
<img src="/img/mazu.png" alt="">
{{-- img を貼る場合は二つの方法がある --}}
{{-- <img src="{{ asset('img/image1.jpg') }}"> --}}
@section('content')
<a href="{{route('diary.create')}}" class="btn btn-primary">新規投稿</a>
@foreach($diaries as $diary)
  <div class="m-4 p-4 border border-primary">
    <p>{{ $diary['title']}}</p>
    <p>{{ $diary['body']}}</p>
    @if($diary->img_url)
  <img src="{{str_replace('public/','storage',$diary->img_url)}}>
  @endif
    <p>{{ $diary['created_at']}}</p>
        {{-- 投稿idとuseridが合わないと編集できないようにするif文 --}}
    @if(Auth::check() && Auth::user()->id == $diary['user_id'])  
    <a class="btn btn-online-su ccess" href="{{ route('diary.edit', ['id' => $diary['id']])}}"><i class="fab fa-accessible-icon"></i></a>

    <form action="{{route('diary.destroy',['id' => $diary['id']])}}" method="POST" class ="d-inline">
        @csrf
        @method('delete')
        <button class="btn btn-outline-danger"><i class="fas fa-adjust"></i></button>
        {{-- outlineを入れると内側が塗りつぶされてるのが外れる --}}
    
    </form>
    @endif
    {{-- いいね機能 --}}
  @if(Auth::check() && $diary->likes->contains(function ($user){
    return $user->id == Auth::user()->id;
  }))
     {{-- 良いねされてたら取り消すボタンを設置 --}}
     <form  style= "display : inline";  action ="{{route('diary.dislike',['id' => $diary['id']])}}" method = "POST">
      @csrf
      <button type="submit" class ="btn btn-outline-danger">
          <i class = "fas fa-thumbs-up"></i>
      <span>{{$diary->likes->count()}}</span>
        </button>
  </form>
  @else
  {{-- いいねされてなければいいねするボタン --}}

      
     <form  style= "display : inline";  action ="{{route('diary.like',['id' => $diary['id']])}}" method = "POST">
        @csrf
        <button type="submit" class ="btn btn-outline-primary">
            <i class = "fas fa-thumbs-up"></i>
        <span>{{$diary->likes->count()}}</span>
          </button>
    </form>
  @endif
    
  </div>
  @endforeach
@endsection
