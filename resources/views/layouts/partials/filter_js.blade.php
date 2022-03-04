<script type="text/javascript">

$('#zone_filter').on('change', function() {
    var stateID = $(this).val();                

       if(stateID) {
        $.ajax({
            url: 'myform/ajax/'+stateID,
            type: "GET",
            dataType: "json",
            success:function(data) {

                $('#wahio_filter').empty();
                $('#wahio_filter').append('<option value="'+ "" +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
                $('#widabe_filter').empty();
                $('#widabe_filter').append('<option value="'+ "" +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                $('#tabia_filter').empty();
                $('#tabia_filter').append('<option value="'+ "" +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                $('#woreda_filter').empty();
                $('#woreda_filter').append('<option value="'+ "" +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                $.each(data, function(key, value) {
                    $('#woreda_filter').append('<option value="'+ key +'">'+ value +'</option>');
                });

            }
        });
    }else{
        $('#woreda_filter').empty();
    }
});
$('#woreda_filter').on('change', function() {
    var stateID = $(this).val();
        


       if(stateID) {
        $.ajax({
            url: 'myform2/ajax/'+stateID,
            type: "GET",
            dataType: "json",
            success:function(data) {

                $('#wahio_filter').empty();
                $('#wahio_filter').append('<option value="'+ "" +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
                $('#widabe_filter').empty();
                $('#widabe_filter').append('<option value="'+ "" +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                $('#tabia_filter').empty();
                $('#tabia_filter').append('<option value="'+ "" +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                $.each(data, function(key, value) {
                    $('#tabia_filter').append('<option value="'+ key +'">'+ value +'</option>');
                });

            }
        });
    }else{
        $('#tabia_filter').empty();
    }
});
$('#tabia_filter').on('change', function() {
    var stateID = $(this).val();
    

       if(stateID) {
        $.ajax({
            url: 'myform2/ajax/wahio/'+stateID,
            type: "GET",
            dataType: "json",
            success:function(data) {

                $('#wahio_filter').empty();
                $('#wahio_filter').append('<option value="'+ "" +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
                $('#widabe_filter').empty();
                $('#widabe_filter').append('<option value="'+ "" +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                $.each(data, function(key, value) {
                    $('#widabe_filter').append('<option value="'+ key +'">'+ value +'</option>');
                });

            }
        });
    }else{
        $('#widabe_filter').empty();
    }
});
$('#widabe_filter').on('change', function() {
    var stateID = $(this).val();

       if(stateID) {
        $.ajax({
            url: 'myform2/ajax/wahio/meseretawi/'+stateID,
            type: "GET",
            dataType: "json",
            success:function(data) {

                
                $('#wahio_filter').empty();
                $('#wahio_filter').append('<option value="'+ "" +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
                $.each(data, function(key, value) {
                    $('#wahio_filter').append('<option value="'+ key +'">'+ value +'</option>');
                });

            },
            error: function(xhr,errorType,exception){                        
              alert(exception);                      
            }
        });
    }else{
        $('#wahio_filter').empty();
    }
});
</script>