<!-- IMAGE UPLOAD  -->
<style>

input[name="{{$name}}"] {
    display: none;
}

input[name="{{$name}}_upload"] {
    display: none;
}

#{{$picture}}{
    border:5px solid #f2f2f2;
}

.custom-file-upload {
    border: 1px solid #f2f2f2;
    border-radius : 20px;
    display: inline-block;
    background-color : #f2f2f2 ; 
    padding: 1px 3px;
    font-size: 12px;
    font-weight:bold;
    cursor: pointer;
    width:40%;
    margin:4px;
}

</style>

<div style="text-align:center;">
    <table width="100%">
        <tr>
            <td style="text-align:center;"><img id="{{$picture}}" src="{{ URL::to('/') }}/storage/images/{{$defaultImage}}" height="{{$height}}" width="{{$width}}" style="border-radius:50%;"></td>
        </tr>
        <tr>
            <td style="text-align:center;">
            <label class="custom-file-upload">
                <input name="{{$name}}_upload" type="file" class="{{$class}}" onchange="preview_image(this)">
                {!! Form::text($name, null, ['class' => 'form-control']) !!}
                Select Image
            </label>
            </td>
        </tr>
    </table>

    
</div>

@stack('scripts')
<script>

$(document).ready(function() {
    //on edit
    var img = document.getElementsByName("{{$name}}")[0].value;
    if(img == "" || img == null){
        $('#{{$picture}}').attr('src', "{{ URL::to('/') }}/storage/images/{{$defaultImage}}");
    } else {
        $('#{{$picture}}').attr('src', "{{ URL::to('/').'/storage/' }}"+img);
    }


});

function preview_image(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#{{$picture}}').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string

    var filename = $('input[type=file]').val().split('\\').pop();

    document.getElementsByName('{{$name}}')[0].value = filename;

  } else {
    $('#{{$picture}}').attr('src', "{{ URL::to('/') }}/storage/images/{{$defaultImage}}");
    document.getElementsByName("{{$name}}")[0].value = "/images/{{$defaultImage}}";
  }
}

</script>
<!-- END IMAGE UPLOAD -->