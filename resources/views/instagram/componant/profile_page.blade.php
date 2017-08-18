@foreach($items as $item)
    @if($item['type'] == 'image')
       @include('instagram.componant.image',['item'=>$item['images']])
    @endif

    @if($item['type'] == 'carousel')
       @include('instagram.componant.carousel',['item'=>$item['carousel_media']])
    @endif

    @if($item['type'] == 'video')
       @include('instagram.componant.video',['item'=>$item['videos']])
    @endif

@endforeach