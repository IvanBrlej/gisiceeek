<script>
    function add(){
        var new_chq_no = parseInt($('#total_chq').val())+1;
        var new_input="<input type='text' id='new_"+new_chq_no+"'>";
        $('#new_chq').append(new_input);
        $('#total_chq').val(new_chq_no)
    }
    function remove(){
        var last_chq_no = $('#total_chq').val();
        if(last_chq_no>1){
            $('#new_'+last_chq_no).remove();
            $('#total_chq').val(last_chq_no-1);
        }
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<input type="text">
<button onclick="add()">Add</button>
<button onclick="remove()">remove</button>
<div id="new_chq"></div>
<input type="hidden" value="1" id="total_chq">