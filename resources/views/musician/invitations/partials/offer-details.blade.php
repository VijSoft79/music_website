
<div class="w-100">
   
    <x-adminlte-profile-widget name="{{ $offer->user->name }}" desc="{{ $offer->user->location }} " layout-type="modern" img="{{ $offer->user->profile_image_url ? asset($offer->user->profile_image_url) : asset('/images/default-image.jpg') }}" class="mb-0" style="background: url('{{ asset($offer->music->image_url) }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <x-adminlte-profile-col-item url="{{ $offer->user->instagram_link ? $offer->user->instagram_link : null }}" icon="fab fa-2x fa-instagram" badge="black" size=4 />
        <x-adminlte-profile-col-item url="{{ $offer->user->facebook_link ? $offer->user->facebook_link : null }}" icon="fab fa-2x fa-facebook" badge="black" size=4 />
        <x-adminlte-profile-col-item url="{{ $offer->user->twitter_link ? $offer->user->twitter_link : null }}" icon="fab fa-2x fa-twitter" badge="black" size=4 />
    </x-adminlte-profile-widget>


    <div class="py-2">
        <div class="row">

            {{-- <div class="col-md-6 mb-2">
                <button class="btn btn-danger w-100">Decline Invitaion</button>
            </div> --}}

            <div class="col-md-12 my-2">
                <div class="card p-3 mb-0">
                    @if (!$offer->status == 1)
                        <div class="row">
                            <div class="col-12">
                                <x-adminlte-profile-widget img="{{ $music->image_url ? asset($music->image_url) : asset('images/default-image.jpg') }}" name="{{ $music->title }}" desc="Release Date: {{ date('M d, Y', strtotime($music->release_date)) }}" layout-type="classic" />
                            </div>
                            <div class="col-2 ml-3 mt-3">
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM8.96963 8.96965C9.26252 8.67676 9.73739 8.67676 10.0303 8.96965L12 10.9393L13.9696 8.96967C14.2625 8.67678 14.7374 8.67678 15.0303 8.96967C15.3232 9.26256 15.3232 9.73744 15.0303 10.0303L13.0606 12L15.0303 13.9696C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73742 15.3232 9.26254 15.3232 8.96965 15.0303C8.67676 14.7374 8.67676 14.2625 8.96965 13.9697L10.9393 12L8.96963 10.0303C8.67673 9.73742 8.67673 9.26254 8.96963 8.96965Z" fill="#DC3545"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="col-8 mt-3">
                                <h3 class="align-middle">Pending Invitation</h3>
                                <div class="row">
                                    <dt class="col-md-12" style="font-size: 22px">Invitation expires on: {{ date('M d, Y', strtotime($offer->expires_at)) }}</dt>
                                    {{-- <dd class="col-md-7"></dd> --}}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-2">
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#33eb00"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="col-10">
                                <h3 class="align-middle">Approved Invitation</h3>
                                <dt class="col-md-12" style="font-size: 22px">Complete On: {{ date('M d, Y', strtotime($offer->date_complete)) }}</dt>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
