<script>

    $(document).ready(function (){
        $('#province_id').change(function (){
            var province = $(this).val();
            var path = "{{URL::route('backend.province.getDistrict')}}";

            $.ajax({
                url:path,
                data: {'province_id':province,'_token':$('meta[name="csrf_token"]').attr('content')},
                method:'post',
                dataType : 'text',
                success:function (response){
                    $('#district_id').empty();
                    $('#district_id').append(response);
                }
            });
        });
    });

</script>
