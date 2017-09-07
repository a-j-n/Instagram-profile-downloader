<input type="hidden" name="url" value="{{$item['standard_resolution']['url']}}">
<figure class="figure col-md-4">
    <img style="height: 400px !important;" src="{{$item['low_resolution']['url']}}"
         alt="{{basename($item['low_resolution']['url'])}}"
         class="img-thumbnail">
    <figcaption class="figure-caption">
        <a download href="{{$item['low_resolution']['url']}}" class="download">
            <i class="fa fa-download fa-2x" aria-hidden="true"></i>
        </a>
    </figcaption>
</figure>
