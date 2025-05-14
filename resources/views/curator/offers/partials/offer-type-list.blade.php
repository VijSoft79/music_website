{{-- chosen offer get --}}
<div class="row">
    <div class="col">
        <div class="card-body p-2">
            <dl class="row">
                <dt class="col-6">Type:</dt>
                <dd class="col-6">{{ $template->basicOffer->offer_type }}</dd>
                <dt class="col-6">Price:</dt>
                <dd class="col-6">{{ $template->basicOffer->offer_price }}</dd>
                <dt class="col-6">description:</dt>
                <dd class="col-6">{!! $template->basicOffer->description !!}</dd>
            </dl>
        </div>
    </div>
    @if ($template->has_premium)
        <div class="col">
            <div class="card-body p-2">
                <dl class="row">
                    <dt class="col-6">Type:</dt>
                    <dd class="col-6">{{ $template->premiumOffer->offer_type }}</dd>
                    <dt class="col-6">Price:</dt>
                    <dd class="col-6">{{ $template->premiumOffer->offer_price }}</dd>
                    <dt class="col-6">description:</dt>
                    <dd class="col-6">{!! $template->premiumOffer->description !!}</dd>
                </dl>
            </div>
        </div>
    @endif
</div>
