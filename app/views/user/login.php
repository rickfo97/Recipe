<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 20:50
 */
?>
<div class="col-md-offset-3 col-md-6 well login">
    <form action="/user/run" method="POST" class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="username">Username</label>
                <div class="col-md-10">
                    <input id="username" name="username" type="text" placeholder="User123" class="form-control input-md"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="password">Password</label>
                <div class="col-md-10">
                    <input id="password" name="password" type="password" placeholder="password123"
                           class="form-control input-md" required>
                </div>
            </div>
            <div class="checkbox col-md-6">
                <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
            <div class="text-right">
                <input type="submit" class="btn btn-default" name="login" value="Login">
            </div>
        </fieldset>
    </form>
</div>