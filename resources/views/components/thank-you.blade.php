<x-sabhero-wrapper::layouts.app>
    <div class="flex h-screen prose text-center justify-center mx-auto text-black items-center">
        @if(session('status') === 'success')
            <div class="alert alert-success">
                <h1>🎉🏠<br /><br />
                    {{ session('message', 'Form submitted successfully!') }}
                </h1>
            </div>
        @endif

        @if(session('status') === 'failure')
            <div class="alert alert-danger">
                <h1>❌🚫<br /><br />
                    {{ session('message', 'There was an issue submitting the form.') }}
                </h1>
            </div>
        @endif
    </div>
</x-sabhero-wrapper::layouts.app>
