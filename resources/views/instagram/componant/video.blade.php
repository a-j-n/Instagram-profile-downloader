<form method="post" action="{{url('download')}}" target="_blank">
    {{csrf_field()}}
    <input name="url" type="hidden" value="{{$item['standard_resolution']['url']}}">
<figure class="figure col-md-4">
    <video  src="{{$item['standard_resolution']['url']}}" class="img-thumbnail" ></video>
    <figcaption class="figure-caption"><a class="download"  ><i class="fa fa-download fa-3x" aria-hidden="true">video</i></a></figcaption>
</figure>
</form>