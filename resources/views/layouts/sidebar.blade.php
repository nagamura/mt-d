<!-- sidebar -->
<div id="responsive-nav" style="overflow-y: overlay;" class="lg:block lg:w-40 bg-gray-800 lg:sticky lg:h-screen top-0 lg:p-4 font-sans">
  <nav>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">発注</span>
    <a href="/order/admin.php?domainFilter=5" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span id="menuOrder" class="lg:pl-2 font-bold relative">資材発注一覧</span>
    </a>
    <a href="/order/standby/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span id="menuOrderStandby" class="lg:pl-2 font-bold relative">資材発注管理</span>
    </a>
    <a href="/order/preparation/" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span id="menuOrderReady" class="lg:pl-2 font-bold relative">資材発注準備</span>
    </a>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">仮発注</span>
    <a href="/preorder/admin.php?domainFilter=5" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span id="menuPreorder" class="lg:pl-2 font-bold relative">仮発注一覧</span>
    </a>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">在庫</span>
    <a href="/stock/admin.php?domainFilter=5" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline text-blue-300 bg-gray-700">
      <span id="menuStock" class="lg:pl-2 font-bold relative">在庫確認一覧</span>
    </a>
    <div onclick="window.open(`/stock/form/form_redirector.php`,'_blank','menubar=no,width=1500,height=900')" class="cursor-pointer flex items-center md:p-3 lg:mt-2 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold">在庫確認入力</span>
    </div>
    <a href="/stock/dai3/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">店舗注文一覧</span>
    </a>
    <a href="/stock/dai3/search.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">店舗注文検索</span>
    </a>
    <a href="/stock/dai3/admin.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">店舗API</span>
    </a>
    <a href="/stock/dai3/price/" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">最低価格更新</span>
    </a>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">見積</span>
    <a href="/quotation/admin.php?domainFilter=5&amp;confirmFilter=1" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span id="menuQuotation" class="lg:pl-2 font-bold relative">見積依頼一覧</span>
    </a>
    <div onclick="window.open(`/quotation/form/form_redirector.php`,'_blank','menubar=no,width=1500,height=900')" class="cursor-pointer flex items-center md:p-3 lg:mt-2 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold">見積依頼入力</span>
    </div>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">価格調査</span>
    <a href="/market/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">価格調査一覧</span>
    </a>
    <span class="lg:pl-2 lg:mt-5 font-bold text-gray-400 inline-block cursor-default">その他</span>
    <a href="/admin/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">管理画面</span>
    </a>
    <a href="/sales/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">お客様依頼</span>
    </a>
    <a href="/customers/index.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">お客様管理</span>
    </a>
    <a href="/customers/workspace.php" class="flex items-center lg:mt-2 md:p-3 lg:py-2 lg:px-2 text-gray-100 rounded hover:bg-gray-700 hover:text-gray-100 hover:no-underline">
      <span class="lg:pl-2 font-bold relative">管理ツール</span>
    </a>
  </nav>
  <a href="/logout.php" class="md:p-3 lg:pl-2 lg:mt-5 font-bold text-gray-100 inline-block cursor-pointer">ログアウト</a>
</div>
<!-- sidebar -->
