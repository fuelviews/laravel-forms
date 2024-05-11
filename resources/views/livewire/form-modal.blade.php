<div>
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center flex-col">
        </div>
        <div wire:click="closeModal" class="absolute md:inset-0 p-4 flex justify-center items-center flex-col">
            <div class="bg-white rounded-lg p-4 shadow-lg max-w-lg w-full border" @click.stop>
                <x-laravel-form::modal.title :title="Form::getModalTitle()" />

                @if($step === 1)
                    <x-laravel-form::steps.step-one :title="Form::getModalStepTitle($step)" />
                @elseif($step === 2)
                    <x-laravel-form::steps.step-two :title="Form::getModalStepTitle($step)" />
                @endif
                <div class="flex justify-between">
                    @if($step > 1)
                        <div class="flex justify-start items-center text-center pr-2 lg:pr-20">
                        <x-laravel-form::buttons.back-button :buttonText="'Back'" />
                        </div>
                    @endif
                    @if($step < $totalSteps)
                        <x-laravel-form::buttons.next-button :buttonText="'Next'" />
                            @if($errors->has('form.submit.limit'))
                                <div class="sm:col-span-2">
                                    <x-laravel-form::error :errorKey="'form.submit.limit'" />
                                </div>
                            @endif
                    @else
                        <div class="flex justify-start items-center text-center pr-2 lg:pr-20">
                            <x-laravel-form::buttons.fake-button :buttonText="'Submit'" />
                            <x-laravel-form::buttons.submit-button :buttonText="'Submit'" />
                        </div>
                    @endif
                        <x-laravel-form::modal.optional-div />
                </div>
            </div>
            <x-laravel-form::modal.tos />
        </div>
    @endif
</div>
