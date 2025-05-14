<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Premium Offer</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
           
            <x-adminlte-input name="premiumName" label="Name" value="{{$OfferTemplate->premiumOffer->name}}"
                placeholder="Name" fgroup-class="col-md-6" disable-feedback class="input"/>

            <x-adminlte-input name="premiumOfferType" label="Invitation Type" value="{{$OfferTemplate->premiumOffer->offer_type}}"
                placeholder="Type" fgroup-class="col-md-6" disable-feedback class="input"/>

            <x-adminlte-input name="premiumOfferPrice" label="Invitation Price" value="{{$OfferTemplate->premiumOffer->offer_price}}"
                placeholder="Price" fgroup-class="col-md-6" disable-feedback class="input"/>

            <x-adminlte-input disabled name="DateUpto" label="Date Updated" value="{{$OfferTemplate->premiumOffer->updated_at}}"
                fgroup-class="col-md-6" disable-feedback class="input"/>  

            <x-adminlte-textarea name="premiumDescription" label="Description" placeholder="Description" rows="5"  fgroup-class="col-md-6" class="input">
                {{ strip_tags($OfferTemplate->premiumOffer->description) }}
            </x-adminlte-textarea>

        </div>
    </div>

</div>