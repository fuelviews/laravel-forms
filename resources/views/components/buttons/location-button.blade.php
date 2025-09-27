<input type="radio" id="location_{{ $location }}" name="location" value="{{ $location }}"
       class="sr-only peer" wire:model="location">

<label for="location_{{ $location }}"
       class="bg-gray-500 text-white font-bold text-md py-2 px-3 cursor-pointer hover:bg-gray-700 peer-checked:bg-gray-700 rounded-lg">
    {{ ucfirst($location) }}
</label>
