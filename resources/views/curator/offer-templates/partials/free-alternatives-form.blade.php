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
            <input name="hidden" type="hidden" value="alter">
            <x-adminlte-input name="alterOffername" label="Invitation Type" value="{{ $OfferTemplate->freeAlternative->type }}" placeholder="Alternative Offer Type" fgroup-class="col-md-6" disable-feedback class="input" />
            
            <x-adminlte-input name="alterUrl" label="Invitation URL" value="{{ $OfferTemplate->freeAlternative->alter_url }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />
            
            <x-adminlte-textarea name="alterdescription" label="Description" placeholder="Description" rows="5" fgroup-class="col-md-12" class="input description w-100">
                {{ strip_tags($OfferTemplate->freeAlternative->alter_description) }}
            </x-adminlte-textarea>
        </div>
    </div>

</div>
