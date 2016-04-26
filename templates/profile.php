<script type="text/javascript" src="/js/profile.js"></script>
<div class="container">
    <div class="col-xs-12 col-sm-9 col-md-6">
        <h1>Update Profile</h1>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <p id="profileEmailStatic" class="form-control-static"><?php echo $_SESSION["email"]; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="profileName" name="name" placeholder="Name">
                </div>
            </div>
            <div class="form-group">
                <label for="major" class="col-sm-2 control-label">Major</label>
                <div class="col-sm-10">
                    <select class="form-control" id="profileMajor" name="Major">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="interests" class="col-sm-2 control-label">Interests</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="profileInterests" name="interests" placeholder="Interests">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Update Profile</button>
                </div>
            </div>
        </form>
        <hr>
        <h1>Change Password</h1>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Change Password</button>
                </div>
            </div>
        </form>
    </div>
</div>