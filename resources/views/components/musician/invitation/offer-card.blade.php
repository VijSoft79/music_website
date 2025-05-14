
<div class="card" style="font-size:20px">
    <div class="card-header bg-light">
        <div class="row">
            <div class="col-6">
                <h4 class="my-0 font-weight-normal">{{ ucfirst($type) }} Offer</h4>
            </div>
        </div>
    </div>
    <div class="card-body text-center">
        <h2> ${{ $template->offer_price }} </h2>
        <ul class="list-unstyled mt-3 mb-4">
            <li>{{ $template->offer_type }}</li>
            <li>{{ $offer->date_complete }}</li>
            <li>{!! $template->description !!}</li>
        </ul>
        <form action="{{ route('musician.invitation.approve', $offer) }}" method="post">
            @csrf
            <input type="hidden" name="approve" value="approve">
            <input type="hidden" name="templateId" value="{{ $template->id }}">
            <input type="hidden" name="offerType" value="{{ $type }}">
            <input type="hidden" name="offerprice" value="{{ $template->offer_price }}">
            <button type="submit" class="btn btn-lg btn-block btn-outline-primary">Choose</button>
        </form>
    </div>
</div>
