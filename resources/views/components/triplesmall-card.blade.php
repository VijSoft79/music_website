<div class="row">
    <div class="col-lg-4 col-6">
        <x-adminlte-small-box title="{{$title1}}" text="Total" icon="{{ $icon1 }} text-xl" theme="info" url="{{ $url1 }}" url-text="More info" />
    </div>  
    <div class="col-lg-4 col-6">
        <x-adminlte-small-box title="{{$title2}}" text="Approved/Completed" icon="{{ $icon2 }} text-xl" theme="success" url="{{ $url2 }}" url-text="More info" />
    </div>
    <div class="col-lg-4 col-6">
        <x-adminlte-small-box title="{{$title3}}" text="Pending Approved" icon="{{ $icon3 }} text-xl" theme="danger" url="{{ $url3 }}" url-text="More info" />
    </div>
</div>