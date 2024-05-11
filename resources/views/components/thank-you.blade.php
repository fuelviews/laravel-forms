@if ($layout)
    <x-layouts.app>
        <x-slot name="slot">
            <div>
                <div class="prose text-center justify-center mx-auto text-black py-12 md:py-24 lg:py-48">
                    @if(session('status') === 'success')
                        <h1>Someone will be in touch with you soon.</h1>
                        <h2 >Take care.</h2>
                    @elseif(session('status') === 'failure')
                        <h1>There was a problem with your submission, please try again later.</h1>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-layouts.app>
@else
    <x-laravel-form::layouts.app>
        <x-slot name="slot">
            <div>
                <div class="prose text-center justify-center mx-auto text-black py-12 md:py-24 lg:py-48">
                    @if(session('status') === 'success')
                        <h1>Someone will be in touch with you soon.</h1>
                        <h2>Take care.</h2>
                    @elseif(session('status') === 'failure')
                        <h1>There was a problem with your submission, please try again later.</h1>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-laravel-form::layouts.app>
@endif
