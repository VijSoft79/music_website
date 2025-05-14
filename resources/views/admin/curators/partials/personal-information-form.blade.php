<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Personal information</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- publication name --}}
            <x-adminlte-input name="name" label="Publication Name" value="{{ old('name', $user->name) }}"
                placeholder="placeholder" fgroup-class="col-md-6" disable-feedback />

            {{-- website --}}
            <x-adminlte-input name="website" label="Webstie" value="{{ old('website', $user->website) }}"
                placeholder="placeholder" fgroup-class="col-md-6" disable-feedback />

            {{-- location --}}
            <x-adminlte-input name="location" label="Location" value="{{ old('location', $user->location) }}"
                placeholder="Enter Location" fgroup-class="col-md-6" disable-feedback />

            <x-adminlte-input name="phone_number" label="Contact" value="{{ old('phone_number', $user->phone_number) }}"
                placeholder="Enter Contact" fgroup-class="col-md-6" disable-feedback />

            <x-adminlte-textarea name="bio" label="Bio" placeholder="Insert Bio..." rows="5"  fgroup-class="col-md-12">
            {{ old('bio', $user->bio) }}
            </x-adminlte-textarea>


        </div>
    </div>

</div>
