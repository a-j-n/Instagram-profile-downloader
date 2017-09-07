@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="data_loaded" class="row data_loaded">
            @include('instagram.componant.profile_page',['items'=>$profile['data']['items']])

        </div>
        <div class="row text-center">
            @include('instagram.load_more')
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.download').click(function () {
            $(this).parents('form').submit();
        })
    </script>
@endpush