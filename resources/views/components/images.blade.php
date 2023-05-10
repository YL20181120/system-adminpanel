@props([
    'id' => uniqid(),
    'images' => []
])

<div {{ $attributes->merge(['class' => 'gap-2 flex justify-center flex-wrap']) }} id="thumb-{{ $id }}">
    @foreach($images as $image)
        <div style="position:relative;">
            {{--            <span data-lazy-src="{{ $image }}"--}}
            {{--                  class="inline-block w-36 h-40 rounded-md shadow-sm cursor-zoom-in mt-2"></span>--}}
            <img data-lazy-src="{{ $image }}"
                 class="inline-block w-36 h-40 rounded-md cursor-zoom-in">
        </div>
    @endforeach
</div>
<script>
    const images = @json($images);
    require(['viewer'], function (viewer) {
        var pictures = document.querySelector(`#thumb-{{ $id }}`);
        var options = {
            inline: false,
            url: 'data-lazy-src',
            fullscreen: true,
            zIndex: 999999999
        };
        new viewer(pictures, options);
    })
</script>
