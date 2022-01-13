<div style="margin: 4px auto">

    @foreach ($items as $item)
        <div style="margin: 10px;display:inline-block">
            <img src="data:image/svg+xml;base64,{{ $item }}" alt="">
        </div>
    @endforeach

</div>