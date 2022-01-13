@extends('layout')


@section('content')
    
<div class="container-fluid" style="background: #ebebeb;">
    <div class="row">
        <div class="card mx-auto my-3  w-50">
            <!-- action="{{ route('GenerateQr') }}" method="post" -->
            <form action="{{ route('GenerateQr') }}" method="post" id="GenerateForm" class="mx-auto w-50">
                <div class="form-group">
                  <label for="QrCount">Qr Count</label>
                  <input type="number" class="form-control" id="QrCount" name="QrCountI" placeholder="Qr Count input" value="1" min="1" required>
                </div>
                <div class="form-group">
                    <label for="QrColor">Qr Color</label>
                    <input type="color" class="form-control" id="QrColor" name="QrColorI" required>
                  </div>
                  <div class="form-group">
                    <label for="QrPrefix">Qr Prefix</label>
                    <select class="form-control" id="QrPrefix" name="QrPrefixI" required >
                        <option value="">Plaese Select Prefix</option>
                        <option value="sms">sms</option>
                        <option value="http">Http://</option>
                        <option value="https">Https://</option>
                        <option value="mail">Mail</option>
                    </select>
                  </div>
                  <div class="form-group">
                      {{ csrf_field() }}
                      <input type="submit" value="Generate" class="btn btn-primary btn-block">
                  </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div id="accordion" class="mx-auto my-3  w-50">
            @foreach ($collections as $coll)
                <div class="card my-1 ">
                <div class="card-header" id="heading{{$coll['id']}}">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$coll['id']}}" aria-expanded="true" aria-controls="collapse{{$coll['id']}}">
                            Collapsible Group Item # {{ $coll['id'] }}
                        </button>
                        </h5>
                        <div class="">
                            <a href="{{ route('print',['coll'=>$coll['id']]) }}" target="_blank" class="btn btn-primary">Print</a>
                            <a href="{{ route('pdf',['coll'=>$coll['id']]) }}" target="_blank" class="btn btn-warning">download as pdf</a>
                        </div>

                    </div>
                </div>

                <!-- convert color -->
                @php
                    list($r, $g, $b) = sscanf($coll['color'], "#%02x%02x%02x");
                @endphp
            
                <div id="collapse{{$coll['id']}}" class="collapse show" aria-labelledby="heading{{$coll['id']}}" data-parent="#accordion">
                    <div class="card-body row">
                        @foreach ($coll['items'] as $qr)
                        <div class="col-sm-2 my-1">
                            {!! QrCode::size(90)->color($r,$g,$b)->generate($qr ) !!}
                        </div>
                        @endforeach
                        
                    </div>
                </div>
                </div>
            @endforeach
          </div>
    </div>

</div>

@endsection

@section('script')

<script>


    //Using Ajax
    // $(document).on('submit','#GenerateForm',function(e){

    //     e.preventDefault()

    //     var data = {
    //         QrColorI:$('input[name=QrColorI]').val(),
    //         QrCountI:$('input[name=QrCountI]').val(),
    //         QrPrefixI:$('select[name=QrPrefixI]').val(),
    //         _token:"{{csrf_token()}}"
    //     }

    //     console.log(data)

    //     $.post({
    //         url:'{{ route("GenerateQr") }}',
    //         data:data,
    //         success:function(data){

    //             console.log(data);
    //         }
    //     })
    
    // })

</script>
@endsection



