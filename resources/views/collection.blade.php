@extends('layout')


@section('content')

<div class="d-flex flex-wrap justify-content-start align-items-center my-2">

    <!-- convert color -->
    @php
        list($r, $g, $b) = sscanf($coll['color'], "#%02x%02x%02x");
    @endphp
    
    @foreach ($coll['items'] as $qr)
    <div class="mx-2">
        {!! QrCode::size(90)->color($r,$g,$b)->generate($qr ) !!}
    </div>
    @endforeach
</div>

@endsection


@section('script')

<script>

$(document).ready(function(){
    window.print();
})

</script>

@endsection