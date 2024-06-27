@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    
                        @csrf
                        <div class="form-group">
                            <label>Dropdown 1</label>
                            <select class="form-control" name="drop1">
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dropdown 2</label>
                            <select class="form-control" name="drop2">
                                <option value="11">Step 11</option>
                                <option value="12">Step 12</option>
                                <option value="13">Step 13</option>
                                <option value="14">Step 14</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success submit_btn">
                            Submit
                        </button>
                    
                    {{-- @if($drop1!="")
                        <p class="alert alert-info">
                            Dropdown 1:- {{$drop1}}<br>
                            Dropdown 2:- {{$drop2}}<br>
                        </p>
                    @else
                        <p class="alert alert-warning">Form has not triggered yet.</p>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.form-group label{display:block; margin:10px 0px; font-size:14px; font-weight:bold;}
.form-group .btn{margin-top:20px; margin-bottom:20px;}
</style>
<script>
function setOption(v){
    let html = "";
        if (v == "1"){
            for(n = 1; n <= 4; n++){
                let vl = "1"+n;
                html += "<option value='"+vl+"'>Step "+vl+"</option>";
            }
        }else  if (v == "2"){
            for(n = 1; n <= 4; n++){
                let vl = "2"+n;
                html += "<option value='"+vl+"'>Step "+vl+"</option>";
            }
        }
        $("select[name='drop2']").html(html);
}
$(document).ready(function(){
    $("select[name='drop1']").change(function(){
        let v = $(this).val();
        setOption(v);
    });
});
</script>
<script language="javascript" type="text/javascript">  
	//create a new WebSocket object.
	var msgBox = $('#message-box');
	var wsUri = "ws://localhost:80/Test/AW/testing_app/public/socket.php"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // connection is open 
		console.log("Welcome");
	}
	// Message received from server
	websocket.onmessage = function(ev) {
		var response 		= JSON.parse(ev.data); //PHP sends Json data
		console.log("Msg", response);
		var res_type 		= response.type; //message type
		var drop1 	= response.drop1; //message text
		var drop2 		= response.drop2; //user name

		switch(res_type){
			case 'usermsg':
                $("select[name='drop1']").val(drop1);
                $("select[name='drop2']").val(drop2);
				break;
			case 'system':
				
				break;
		}

	};
	
	websocket.onerror	= function(ev){ console.log(ev.data) }; 
	websocket.onclose 	= function(ev){ console.log("Connection closed") }; 

	//Message send button
	$('.submit_btn').click(function(e){
		send_message();
        return false;
	});
	
	//Send message
	function send_message(){
		var drop1 = $("select[name='drop1']").val(); //user message text
		var drop2 = $("select[name='drop2']").val(); //user name
		

		//prepare json data
		var msg = {
			drop1: drop1,
			drop2: drop2,
		};
		$.get("{{url('save-socket')}}?drop1="+drop1+"&drop2="+drop2, function(data, status){});
        websocket.onopen = () => websocket.send(JSON.stringify(msg));	
	}
    setInterval(function(){
        $.get("{{url('get-socket')}}", function(data, status){
            if (data.drop1!=""){
                $("select[name='drop1']").val(data.drop1); 
                setOption(data.drop1);   
            }
            if (data.drop2!=""){
                $("select[name='drop2']").val(data.drop2);
            }
        });
    }, 1000);
</script>
@endsection
