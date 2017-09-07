@foreach($item as $photo)
    @if($photo['type'] == 'image')
        @include('instagram.componant.image',['item'=>$photo['images']])
    @elseif($photo['type'] == 'video')
        <input name="url" type="hidden" value="{{$photo['videos']['standard_resolution']['url']}}">
        <figure class="figure col-md-4">
            <img style="height: 400px !important;" src="{{$photo['videos']['standard_resolution']['url']}}" class="img-thumbnail" >
            <figcaption class="figure-caption"><a  download href="{{$photo['videos']['standard_resolution']['url']}}" class="download"  ><i class="fa fa-download fa-2x" aria-hidden="true">video</i></a></figcaption>
        </figure>
    @endif
@endforeach
