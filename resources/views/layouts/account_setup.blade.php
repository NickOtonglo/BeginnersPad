<div class="jumbotron">
            <div class="container-fluid">
                <h1>Hello user,</h1>
                <p>Select your account type and click "Submit" to finish setting up your account</p>
                </p>
            </div>
            <div class="container-fluid">
            	<form action="/index" method="POST">
               		{{csrf_field()}}
               		<div class="btn-group">
		                <p>
		                    <input type="radio" name="user_type" id="customer" value="5" checked> Customer</input>
		                </p>
		                <p>
		                    <input type="radio" name="user_type" id="lister" value="4"> Lister</input>
		                </p>	
	                </div>
	                <div class="container-fluid">
                		<p>
                    		<a><input class="btn btn-primary" type="submit" value="Submit"></a>
                		</p>
            		</div>
               	</form>
            </div>
        </div>