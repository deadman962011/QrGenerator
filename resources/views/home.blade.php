<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body style="background: #ebebeb;">
    <div class="container-fluid">
        <div class="row">
            <div class="card mx-auto my-3  w-50">
                <!-- action="{{ route('GenerateQr') }}" method="post" -->
                <form id="GenerateForm" class="mx-auto w-50">
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
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$coll['id']}}" aria-expanded="false" aria-controls="collapse{{$coll['id']}}">
                                Collapsible Group Item # {{ $coll['id'] }}
                            </button>
                            </h5>
                            <div class="">
                                <button class="btn btn-primary">Print</button>
                                <button class="btn btn-warning">download as pdf</button>
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
                            <div class="col-sm-2 m-1">
                                {!! QrCode::size(90)->color($r,$g,$b)->generate($qr) !!}
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    </div>
                @endforeach
              </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>

    $(document).on('submit','#GenerateForm',function(e){

        e.preventDefault()

        var data = {
            QrColorI:$('input[name=QrColorI]').val(),
            QrCountI:$('input[name=QrCountI]').val(),
            QrPrefixI:$('select[name=QrPrefixI]').val(),
            _token:"{{csrf_token()}}"
        }

        console.log(data)

        $.post({
            url:'{{ route("GenerateQr") }}',
            data:data,
            success:function(data){

                console.log(data);
            }
        })
    
    })

</script>


</body>
</html>