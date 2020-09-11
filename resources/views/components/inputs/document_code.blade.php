<div>

    @php

    $new_number = "";
    $new_code = "";

    if($formType == "create") {

        $new_number = str_pad(($lastSerialNo+$commonDifference), $formatLength, '0', STR_PAD_LEFT);
        $new_code = ($prefix).(str_pad(($lastSerialNo+$commonDifference), $formatLength, '0', STR_PAD_LEFT));

    }


    @endphp

@stack('scripts')
<script>

    $(document).ready(function () {

        var form_type = "{{$formType}}";

        if(form_type == "create") {
            document.getElementById('{{$numberFieldId}}').value = "{{$new_number}}";
            document.getElementById('{{$codeFieldId}}').value = "{{$new_code}}";
        }

        $( "#{{$numberFieldId}}" ).change(function() {

            var lastSerialNo = "{{$lastSerialNo}}";
            var typedSerialNo = document.getElementById('{{$numberFieldId}}').value;

            var prefix = "{{$prefix}}";
            var formatLength = "{{$formatLength}}";
            var commonDifference = "{{$commonDifference}}";

            if(typedSerialNo == null || typedSerialNo == ""){
                var serialNo = parseInt(lastSerialNo)+parseInt(commonDifference);
            } else {
                var serialNo = parseInt(typedSerialNo);
            }

            var new_number = "" + serialNo;
            while (new_number.length < formatLength) {
                new_number = "0" + new_number;
            }

            var new_code = prefix+new_number;

            document.getElementById('{{$numberFieldId}}').value = (new_number);
            document.getElementById('{{$codeFieldId}}').value = new_code;

            });

    });

    

</script>

</div>