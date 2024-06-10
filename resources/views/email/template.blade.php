@if($url)
    <a href="{{ $url }}" target="_blank">
        {!! $content !!}
    </a>
@else
    {!! $content !!}
@endif
