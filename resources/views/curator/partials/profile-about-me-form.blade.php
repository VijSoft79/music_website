<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                About Me
            </div>
            <div class="col-8"></div>
            <div class="col-2 text-end">
                Status: <b
                    class="{{ Auth::user()->is_approve == 1 ? 'text-success' : 'text-danger' }}">{{ Auth::user()->is_approve == 1 ? 'Approve' : 'Pending Approve' }}</b>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Name -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Publication</label>
                    <div class="col-sm-10">
                        <x-adminlte-input name="name" 
                        value="{{ Auth::user()->name }}" />
                    </div>
                </div>
            </div>

            {{-- email --}}
            <div class="col-12  col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                       <x-adminlte-input type="email" name="email" value="{{ Auth::user()->email }}" />
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact"
                            value="{{ old('contact', Auth::user()->phone_number) }}" class="form-control"
                            id="contact">
                    </div>
                </div>
                @error('contact')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            @if (Auth::user()->hasRole('curator'))
                
            
                <!-- location -->
                <div class="col-12 col-md-6">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Location</label>
                        <div class="col-sm-10">
                            <x-adminlte-select name="location" fgroup-class="">
                                <option value="{{ old('location', Auth::user()->location) }}" selected>{{ old('location', Auth::user()->location) }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country['name']}}" data-capital="{{$country['calling_code']}}">{{$country['name']}}</option>
                                @endforeach
                                
                            </x-adminlte-select>
                        </div>
                    </div>
                </div>

                {{-- date Published --}}
                <div class="col-12 col-md-6 px-1">
                    <label for="inputPassword" class="col-12 col-sm-6 col-form-label">Publication Established Date</label>
                    <input type="date" name="date_founded" class="form-control" value="{{ old('date_founded', Auth::user()->date_founded) }}">
                </div>

                {{-- website --}}
                <div class="col-12 col-md-6">
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-12">
                            <input type="text" name="website" value="{{ old('website',Auth::user()->website) }}" class="form-control" >
                        </div>
                    </div>
                </div>

                {{-- paypal --}}
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="paypal" class="col-sm-12 col-form-label">PayPal Email (for payout requests) <small class="text-danger">*change if you are using a different email for paypal*</small></label>
                        <div class="col-sm-12">
                            @if (Auth::user()->paypal)
                                <input type="text" name="paypal" value="{{ Auth::user()->paypal->paypal_address }}" class="form-control" id="paypal" >
                            @else
                                <input type="text" name="paypal" value="{{ Auth::user()->email }}" class="form-control" id="paypal" >
                            @endif    
                        </div>
                    </div>
                </div>

                {{-- curator bio --}}
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                        <div class="col-sm-12">
                            <textarea name="bio" class="form-control" rows="5" placeholder="Tell us about your publication" id="bio"> {{ old('bio', Auth::user()->bio) }}</textarea>
                        </div>
                    </div>
                    @error('bio')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if (Auth::user()->is_approve != 1)
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="message_to_admin" class="col-sm-2 col-form-label">Message To Admin</label>
                        <div class="col-sm-12">
                            <textarea name="message_to_admin" class="form-control" placeholder="Send A message to admin for faster Approval" id="message_to_admin">{{ Auth::user()->message_to_admin }}</textarea>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@section('js')
    <script>
        
        document.getElementById('location').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var countryTel = selectedOption.value;
            var capital = selectedOption.getAttribute('data-capital');
            check = document.getElementById('contact').value = capital;

            // console.log(check);
        });


    </script>
@stop