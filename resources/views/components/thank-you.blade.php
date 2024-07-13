<x-layouts-wrapper::layouts.app>
    <div class="flex h-screen prose text-center justify-center mx-auto text-black items-center">
        @if(session('status') === 'success')
            <h1>Someone will be in touch with you soon.</h1>
            <h2 >Take care.</h2>
        @elseif(session('status') === 'failure')
            <h1>There was a problem with your submission, please try again later.</h1>
        @endif
    </div>
</x-layouts-wrapper::layouts.app>
