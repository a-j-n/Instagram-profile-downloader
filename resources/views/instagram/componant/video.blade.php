 <input name="url" type="hidden" value="{{$item['images']['standard_resolution']['url']}}">
<figure class="figure col-md-4">
    <img style="height: 400px !important;" src="{{$item['images']['standard_resolution']['url']}}" class="img-thumbnail" >
    <figcaption class="figure-caption"><a  download href="{{$item['videos']['standard_resolution']['url']}}" class="download"  ><i class="fa fa-download fa-2x" aria-hidden="true">video</i></a></figcaption>
</figure>