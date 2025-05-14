<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Basic Invitation</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php
                $status = $OfferTemplate->status == 1 ? 'Approve' : 'Pending';
            @endphp

            <x-adminlte-input name="offerName" label="Invitation Name" value="{{$OfferTemplate->basicOffer->name}}"
                placeholder="Offer Name" fgroup-class="col-md-6" disable-feedback class="input"/>

            <x-adminlte-input name="offerType" label="Invitation Type" value="{{$OfferTemplate->basicOffer->offer_type}}"
                placeholder="placeholder" fgroup-class="col-md-6" disable-feedback class="input"/>

            <x-adminlte-input name="offerPrice" label="Invitation Price" value="{{$OfferTemplate->basicOffer->offer_price}}"
                placeholder="Enter Contact" fgroup-class="col-md-6" disable-feedback class="input"/>
                
            <x-adminlte-input name="status" label="Status" value="{{ $status }}"
                disabled fgroup-class="col-md-6" disable-feedback class="input"/>
            
            <x-adminlte-textarea name="offerIntroduction" label="Introduction" placeholder="Introduction" rows="5"  fgroup-class="col-md-6" class="input">
                {{ strip_tags($OfferTemplate->basicOffer->introduction_message) }}
            </x-adminlte-textarea>
            <x-adminlte-textarea name="offerDescription" label="Description" placeholder="Description" rows="5"  fgroup-class="col-md-6" class="input">
                {{ strip_tags($OfferTemplate->basicOffer->description) }}
            </x-adminlte-textarea>

        </div>
    </div>

</div>