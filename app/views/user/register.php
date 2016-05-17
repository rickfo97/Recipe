<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 21:18
 */
?>
<div class="col-md-offset-3 col-md-6 well login">
    <form action="/user/create" method="POST" class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="email">Email</label>
                <div class="col-md-10">
                    <input id="email" class="form-control" type="email" placeholder="email@example.com" name="email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="username">Username</label>
                <div class="col-md-10">
                    <input onkeyup="checkUsername(this)" id="username" name="username" type="text" placeholder="User123" class="form-control"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="password">Password</label>
                <div class="col-md-10">
                    <input id="password" name="password" type="password" placeholder="supersecretpassword123"
                           class="form-control" required>
                </div>
            </div>
            <div class="text-right">
                <input type="submit" class="btn btn-default" name="register" value="Register">
            </div>
        </fieldset>
    </form>
</div>