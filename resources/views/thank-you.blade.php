@extends('laravel-form::components.layouts.app')

@section('content')
    <div>
        <div class="prose text-center justify-center mx-auto text-white py-12 md:py-24 lg:py-48">
            @if(session('status') === 'success')
                <h1 class="text-white">Someone will be in touch with you soon.</h1>
                <h2 class="text-white">Take care.</h2>
            @elseif(session('status') === 'failure')
                <h1 class="text-white">There was a problem with your submission, please try again later.</h1>
            @else
                <h1 class="text-white">Hmmmmm.</h1>
            @endif
        </div>
    </div>
@endsection
