<x-sabhero-wrapper::layouts.app>
    <div class="flex h-screen prose dark:prose-invert text-center justify-center mx-auto text-black dark:text-white items-center">
        @if(session('status') === 'success')
            <div class="alert alert-success dark:bg-green-900 dark:text-green-100">
                <h1 class="text-black dark:text-white">🎉🏠<br /><br />
                    {{ session('message', 'Form submitted successfully!') }}
                </h1>
            </div>
        @endif

        @if(session('status') === 'failure')
            <div class="alert alert-danger dark:bg-red-900 dark:text-red-100">
                <h1 class="text-black dark:text-white">❌🚫<br /><br />
                    {{ session('message', 'There was an issue submitting the form.') }}
                </h1>
            </div>
        @endif
    </div>
</x-sabhero-wrapper::layouts.app>
