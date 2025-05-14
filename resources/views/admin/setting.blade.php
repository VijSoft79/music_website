@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Admin Settings</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-9 m-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold">Options</h3>
                </div>
                <div class="card-body">
                    {{-- <div class="row justify-content-center"> --}}
                        <div class=" text-left">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="autoApproveSong">
                                    <label class="custom-control-label" for="autoApproveSong">Auto Approve Song</label>
                                </div>
                            

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="autoApproveMusician">
                                    <label class="custom-control-label" for="autoApproveMusician">Auto Approve Musician</label>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@stop

@section('js')
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const AutoApproveSong = document.getElementById('autoApproveSong');
        const AutoApproveMusician = document.getElementById('autoApproveMusician');
        var settings = @json($settings);

        
        settings.forEach(function(setting) {
            

            if (setting.name == "autoApproveSong" && setting.status == 1) {
                //console.log('checked');
                AutoApproveSong.checked = true;
                
            }
            if (setting.name == "autoApproveMusician" && setting.status == 1) {
                //console.log('checked');
                AutoApproveMusician.checked = true;
                
            }
            
        });


        function logAndSendSwitchValue(event) {
            //console.log(`${event.target.id} is ${event.target.checked ? 'checked' : 'unchecked'}`);

                // Create the data object
            const data = {
                switchId: event.target.id,
                switchValue: event.target.checked
            };
            //console.log(data);
                // Send AJAX request
            $.ajax({
                url: '{{ route('admin.setting.change') }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function(response) {
                    console.log('Data sent successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error sending data:', error, xhr, status );
                }
            });
        }

        AutoApproveSong.addEventListener('change', logAndSendSwitchValue);
        AutoApproveMusician.addEventListener('change', logAndSendSwitchValue);

        
    });
</script>

@stop