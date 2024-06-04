<x-dynamic-component :component="$layoutsApp">
        <x-slot name="slot">
            <div class="flex h-screen justify-center items-center">
                <div class="prose text-center justify-center mx-auto text-black">
                    @if(session('status') === 'success')
                        <h1>Someone will be in touch with you soon.</h1>
                        <h2 >Take care.</h2>
                    @elseif(session('status') === 'failure')
                        <h1>There was a problem with your submission, please try again later.</h1>
                    @endif
                </div>
            </div>
        </x-slot>
</x-dynamic-component>
