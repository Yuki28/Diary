@extends('layout')

@section('title')
my page
@endsection

@section('content')
<a href="{{route('diary.create')}}" class="btn btn-primary">新規投稿</a>
   @foreach($diaries as $diary)
        <div class="m-4 p-4 border border-primary">
          <p>{{ $diary['title']}}</p>
          <p>{{ $diary['body']}}</p>
          <p>{{ $diary['created_at']}}</p>
              {{-- 投稿idとuseridが合わないと編集できないようにするif文 --}}
          @if(Auth::check() && Auth::user()->id == $diary['user_id'])  
          <a class="btn btn-online-success" href="{{ route('diary.edit', ['id' => $diary['id']])}}"><i class="fab fa-accessible-icon"></i></a>

          <form action="{{route('diary.destroy',['id' => $diary['id']])}}" method="POST" class ="d-inline">
              @csrf
              @method('delete')
              <button class="btn btn-outline-danger"><i class="fas fa-adjust"></i></button>
              {{-- outlineを入れると内側が塗りつぶされてるのが外れる --}}
          
          </form>
          @endif
        </div>
  @endforeach
@endsection