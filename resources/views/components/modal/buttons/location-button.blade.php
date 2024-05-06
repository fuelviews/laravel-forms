<input type="radio" id="{{ $location }}" name="location" value="{{ $location }}"
       class="sr-only peer" {{ old('location', session('location')) === $location ? 'checked' : '' }}>

<label for="{{ $location }}"
       class="bg-gray-500 text-white font-bold text-md py-4 px-3 cursor-pointer hover:bg-blue-500 peer-checked:bg-blue-700 rounded-lg">
    {{ ucfirst($location) }}
</label>
