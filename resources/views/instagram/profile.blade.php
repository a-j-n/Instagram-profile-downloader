@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('instagram.componant.profile_page',['items'=>$profile['data']['items']])
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.download').click(function () {
            var link = $(this).attr('link');
            window.open("{{url('download')}}" + "/" + link, '_blank');
        })</script>
@endpush