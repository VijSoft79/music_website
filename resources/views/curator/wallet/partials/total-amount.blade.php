<div class="col-12 py-4">
    <div class="row">
        <div class="col-6 h4 font-weight-bold">Total Balance</div>
        <div class="col-6 text-right h4 font-weight-bold text-danger">${{ $wallet != null ? number_format($wallet->amount, 2) : 0 }}</div>
    </div>
</div>