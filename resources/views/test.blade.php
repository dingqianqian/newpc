<div class="visible-print text-center">
    {!! QrCode::size(500)->encoding('UTF-8')->generate("weixin://wxpay/bizpayurl?pr=wWtzO7c") !!}
    <p>Scan me to return to the original page.</p>
</div>