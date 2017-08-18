<form method="post" action="{{url('download')}}" target="_blank">
    {{csrf_field()}}
    <input type="hidden" name="url" value="{{$item['standard_resolution']['url']}}">
    <figure class="figure col-md-4">
        <img src="{{$item['low_resolution']['url']}}" alt="{{basename($item['low_resolution']['url'])}}"
             class="img-thumbnail">
        <figcaption class="figure-caption">
            <a class="download">
                <i class="fa fa-download fa-2x" aria-hidden="true"></i>
            </a>
        </figcaption>
    </figure>
</form>