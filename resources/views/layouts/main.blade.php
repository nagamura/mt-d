<!doctype html>
<html lang="ja">
@include('layouts.head')
  <body>
  <div id='wrapper'>
    <div id='main' class='flex flex-col text-sm lg:flex-row'>
@include('layouts.sidebar')
@yield('content')
    </div>
  </div>
</body>
</html>
