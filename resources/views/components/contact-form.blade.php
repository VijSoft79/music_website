<div>
    <button type="button" class="btn btn-link text-primary" data-toggle="modal" data-target="#contactForm">
        Something wrong with this form?
    </button>


    <x-adminlte-modal id="contactForm" title="Contact" theme="info"  size='lg' aria-hidden="true" aria-labelledby="contactFormModalLabel" icon="fa-regular fa-envelope">
        <form action="{{ route('send.problem') }}" method="post">
            @csrf
            <x-adminlte-input label="Email" name="email"/>

            <x-adminlte-input label="Subject" name="subject"/>

            <x-adminlte-textarea name="message" label="Message" rows=5 igroup-size="sm" placeholder="Message Body">
                
            </x-adminlte-textarea>

            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save" />
        </form>
    </x-adminlte-modal>
    
</div>