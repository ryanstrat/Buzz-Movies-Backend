<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-6">
            <h1>Login</h1>
            <form class="form-horizontal" action="login" method="post">
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" placeholder="user@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Sign in</button>
                    </div>
                </div>
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-6">
            <h1>Register</h1>
            <form class="form-horizontal" action="register" method="post">
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" placeholder="user@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="passwordConfirm" class="col-sm-4 control-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </div>
            </form>
            <hr>
        </div>
    </div>
</div>