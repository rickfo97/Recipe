<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-16
 * Time: 18:25
 */
?>
<div class="col-md-offset-3 col-md-6 well login">
    <form action="/recipe/create" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="name">name</label>
                <div class="col-md-10">
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="description">Description</label>
                <div class="col-md-10">
                    <textarea id="description" class="form-control" name="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="chef">Chef</label>
                <div class="col-md-5">
                    <input onkeyup="lookupChef(this)" type="text" id="chef" name="chef" class="form-control">
                </div>
                <div class="col-md-5">
                    <select id="chef-select" class="form-control" name="chef-select">
                        <option value="no-chef">Search for chef</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="images">Thumbnail</label>
                <div class="col-md-10">
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="images">Images</label>
                <div class="col-md-10">
                    <input type="file" id="images" name="images[]" multiple>
                </div>
            </div>
            <div id="ingredients" class="col-md-5 form-group">
                <button id="addingredient" onclick="addRow('ingredients', 'ingredient');" type="button"	class="btn btn-success">+</button>
            </div>
            <div id="steps" class="col-md-6 col-md-offset-1 form-group">
                <button id="addstep" onclick="addRow('steps', 'step');" type="button" class="btn btn-success">+</button>
            </div>
            <div class="text-right">
                <input type="submit" class="btn btn-default" name="register" value="Upload">
            </div>
        </fieldset>
    </form>
</div>