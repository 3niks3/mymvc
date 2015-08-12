<div class="row">
    <div class="col-md-4 col-md-offset-4">
        

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Autorizācija</h3>
                </div>
                <div class="panel-body">
                    
                    <form action="" method="POST">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Your Username">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Your Password">
                        </div>
                        <div class="form-group text-center">            
                            <button type="submit" class="btn btn-default">Login</button>
                        </div>
                        <input type="hidden" name="token" value="<?=Token::generate()?>">
                        

                    </form>
                        <div class="form-group text-center">
                            <a href="register"><button class="btn btn-primary">Register</button></a>
                        </div>

                </div>
            </div>        

    </div>
</div>