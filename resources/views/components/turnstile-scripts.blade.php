@if(config('forms.turnstile.enabled'))
    @once
        <script src="{{ config('forms.turnstile.script_url', 'https://challenges.cloudflare.com/turnstile/v0/api.js') }}" async defer></script>

        <script>
            window.turnstileCallbacks = window.turnstileCallbacks || {};

            // Global callback for successful verification
            window.turnstileCallbacks.onSuccess = function(token) {
                console.log('Turnstile verification successful');

                // Dispatch a custom event that Livewire components can listen to
                window.dispatchEvent(new CustomEvent('turnstile-success', {
                    detail: { token: token }
                }));

                // If using Livewire, update the wire:model
                const turnstileElement = document.querySelector('.cf-turnstile');
                if (turnstileElement && window.Livewire) {
                    const wireModel = turnstileElement.getAttribute('wire:model');
                    if (wireModel) {
                        const component = window.Livewire.find(
                            turnstileElement.closest('[wire\\:id]').getAttribute('wire:id')
                        );
                        if (component) {
                            component.set(wireModel, token);
                        }
                    }
                }
            };

            // Global error callback
            window.turnstileCallbacks.onError = function(error) {
                console.error('Turnstile error:', error);
                window.dispatchEvent(new CustomEvent('turnstile-error', {
                    detail: { error: error }
                }));
            };

            // Global expired callback
            window.turnstileCallbacks.onExpired = function() {
                console.log('Turnstile token expired');
                window.dispatchEvent(new CustomEvent('turnstile-expired'));

                // Reset Livewire wire:model if exists
                const turnstileElement = document.querySelector('.cf-turnstile');
                if (turnstileElement && window.Livewire) {
                    const wireModel = turnstileElement.getAttribute('wire:model');
                    if (wireModel) {
                        const component = window.Livewire.find(
                            turnstileElement.closest('[wire\\:id]').getAttribute('wire:id')
                        );
                        if (component) {
                            component.set(wireModel, null);
                        }
                    }
                }
            };

            // Helper function to manually reset Turnstile
            window.resetTurnstile = function(widgetId) {
                if (window.turnstile && widgetId) {
                    window.turnstile.reset(widgetId);
                } else if (window.turnstile) {
                    // Reset all widgets if no specific ID provided
                    const widgets = document.querySelectorAll('.cf-turnstile');
                    widgets.forEach(widget => {
                        const id = widget.getAttribute('id');
                        if (id && window.turnstile.getResponse(id)) {
                            window.turnstile.reset(id);
                        }
                    });
                }
            };

            // Helper function to get Turnstile response
            window.getTurnstileResponse = function(widgetId) {
                if (window.turnstile && widgetId) {
                    return window.turnstile.getResponse(widgetId);
                }
                return null;
            };
        </script>
    @endonce
@endif
