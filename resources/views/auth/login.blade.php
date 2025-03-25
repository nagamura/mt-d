<html lang="ja">
<head>
<meta charset="utf-8">
@vite(['resources/css/app.css'])
<title>ログイン</title>
</head>
<body>						  
  <div class="flex justify-center items-center h-screen text-center bg-gray-400">
    <div class="shadow-xl p-10 bg-white max-w-xl rounded-2xl">
      <h1 class="text-4xl font-black mb-8"><img src="/img/top_logo.png" style="width: 300px;" alt="ミタドン"></h1>
      <a href="{{ route('auth.redirect') }}" class="inline-block bg-green-600 hover:bg-blue-dark text-white font-bold py-3 px-6 mb-3 rounded">接続</a>
      <!--
      <span class="inline-block bg-gray-300 hover:bg-blue-dark text-white font-bold py-3 px-6 mb-3 rounded">接続</span>
      <p class="font-bold">ブラウザが非対応です。<br><a class="text-blue-500 underline" href="https://www.google.com/chrome/" target="_brank">Google Chrome</a>をご使用ください 。</p>
      <p class="mt-2 font-bold">現在のブラウザ({{ $ua }})</p>
      -->
    </div>
  </div>
</body>
</html>';
