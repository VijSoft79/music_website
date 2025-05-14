<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Free Alternatives</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <x-adminlte-input name="alterOffername" label="Invitation Type" value="{{$OfferTemplate->freeAlternative->type}}"
                placeholder="Alternative Invitation Type" fgroup-class="col-md-6" disable-feedback class="input"/>
            <x-adminlte-input name="alterUrl" label="Invitation URL" value="{{$OfferTemplate->freeAlternative->alter_url}}"
                placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input"/>
                {{-- {!! $OfferTemplate->freeAlternative->alter_description !!} --}}
            <x-adminlte-textarea name="alterdescription" label="Description" placeholder="Description" rows="5"  fgroup-class="col-md-12" class="input">
                {{ strip_tags($OfferTemplate->freeAlternative->alter_description) }}
            </x-adminlte-textarea>
        </div>
    </div>
</div>