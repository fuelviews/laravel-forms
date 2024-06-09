<div class="flex justify-center mx-auto h-screen items-center z-50">
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center flex-col">
        </div>
        <div wire:click="closeModal" class="absolute md:inset-0 p-4 flex justify-center items-center flex-col">
            <div class="bg-white rounded-lg p-4 shadow-lg max-w-lg w-full border mx-auto" @click.stop>
                <x-forms::modal.title :title="Forms::getModalTitle()" />

                @if($step === 1)
                    <x-forms::steps.step-one :title="Forms::getModalStepTitle($step)" />
                @elseif($step === 2)
                    <x-forms::steps.step-two :title="Forms::getModalStepTitle($step)" />
                @endif
                <div class="flex justify-between">
                    @if($step > 1)
                        <div class="flex justify-start items-center text-center pr-2 lg:pr-20">
                        <x-forms::buttons.back-button :buttonText="'Back'" />
                        </div>
                    @endif
                    @if($step < $totalSteps)
                        <x-forms::buttons.next-button :buttonText="'Next'" />
                            @if($errors->has('form.submit.limit'))
                                <div class="sm:col-span-2">
                                    <x-forms::error :errorKey="'form.submit.limit'" />
                                </div>
                            @endif
                    @else
                        <div class="flex justify-start items-center text-center pr-2 lg:pr-20">
                            <x-forms::buttons.fake-button :buttonText="'Submit'" />
                            <x-forms::buttons.submit-button :buttonText="'Submit'" />
                        </div>
                    @endif
                        <x-forms::modal.optional-div />
                </div>
            </div>
            <x-forms::modal.tos />
        </div>
    @endif
</div>
