<div class="row">
    <div class="col-md-4 col-md-offset-4">
        

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Registrācija</h3>
                </div>
                <div class="panel-body">
                    
                    <form action="" method="POST" onsubmit="return validate()">

                        <div class="form-group username_block">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Your Username">
                        </div>

                        <div class="form-group name_block">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                        </div>

                        <div class="form-group password_block">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control password_error" id="password" placeholder="Your Password">
                        </div>

                        <div class="form-group">
                            <label for="password_again">Password again</label>
                            <input type="password" name="password_again" class="form-control" id="password_again" placeholder="Password again">
                        </div>

                        <div class="form-group text-center">            
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        

                    </form>
                </div>
            </div>

            <script>
            function validate(){
                
                var inputs = new Object();

                inputs.username = $('#username').val();
                inputs.name = $('#name').val();
                inputs.password = $('#password').val();
                var password_again = $('#password_again').val();

                var errors= new Object();


                if(inputs.username ==null || inputs.username ==""){
                    errors['username'] = 'Username is required!';
                }else if(inputs.username.length<2){
                    errors['username'] = 'Username must be at least 2 characters long!';
                }else if(inputs.username.length>20){
                    errors['username']='Username cannot contains more than 20 characters!'
                }

                if(inputs.name ==null || inputs.name ==""){
                     errors['name'] = 'Name is required!';
                }else if(inputs.name.length<2){
                    errors['name'] = 'Name must be at least 2 characters long!';
                }else if(inputs.name.length>50){
                    errors['name']='Username cannot contains more than 50 character!s'
                }

                if(inputs.password ==null || inputs.password ==""){
                    errors['password'] = 'Password is required!';
                }else if(inputs.password.length<4){
                    errors['password'] = 'Password must contain 4 characters!';
                }else if(inputs.password != password_again){
                    errors['password']='Password and password again must match!'
                }



                    $('span').remove('.help-block');
                    $('div').find('.form-group').removeClass('has-error');

                    $.each( errors, function( key, value ) {
                        if(value !=null || errors.hasOwnProperty(key)){
                                $('div').find('.'+key+'_block').addClass('has-error');
                                $('#'+key).after('<span class="help-block text-danger"><p class="text-danger">'+value+'</p></span>');
                        }
                    });

                    console.log('Class exist ' + Object.keys(errors).length);
                    if(Object.keys(errors).length){
                        return false;
                    }

            }
            </script>        

    </div>
</div>