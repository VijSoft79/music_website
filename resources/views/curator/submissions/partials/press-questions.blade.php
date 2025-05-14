<div class="col-12">
    @if($music->pressQuestion)
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3>Press realease:</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <dl class="col-md-6">
                    <dt>What is being released? (Single, album, music video)</dt>
                    <dd>{{ $music->pressQuestion->question0 }}</dd>

                    <dt>What is the style or genre of music?</dt>
                    <dd>{{ $music->pressQuestion->question1 }}</dd>

                    <dt>Where can people find the release? (Platforms, live venues)</dt>
                    <dd>{{ $music->pressQuestion->question2 }}</dd>

                    <dt>Why is this release noteworthy?</dt>
                    <dd>{{ $music->pressQuestion->question3 }}</dd>
                </dl>

                <dl class="col-md-6">
                    <dt>What inspired the artist to create this music?</dt>
                    <dd>{{ $music->pressQuestion->question4 }}</dd>

                    <dt>What can listeners expect from the release?</dt>
                    <dd>{{ $music->pressQuestion->question5 }}</dd>

                    <dt>What is the story behind the release?</dt>
                    <dd>{{ $music->pressQuestion->question6 }}</dd>

                    <dt>What makes the release stand out from others?</dt>
                    <dd>{{ $music->pressQuestion->question7 }}</dd>
                </dl>
            </div>
           

        </div>
        
    </div>
    @endif
    
</div>