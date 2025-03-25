@extends('layouts.main')
@section('title', 'マイページ')
@section('content')
<div class="p-5 lg:mt-6 lg:mt-0 bg-white">
  <p>ID: {{ $user['id'] }} </p>
  <p>NAME: {{ $user['name'] }} </p>
  <p>E-MAIL: {{ $user['email'] }} </p>
@auth  
  <a href="{{ route('auth.logout') }}" class="text-blue-500 inline-block cursor-pointer">ログアウト</a>
@endauth
</div>
@endsection
