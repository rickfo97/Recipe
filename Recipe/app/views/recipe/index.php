<?php
include '../app/language/sv.php';
foreach ($data['list'] as $recipe) {
    ?>
    <div class="col-sm-4 recipe">
        <div class="col-sm-12">
            <a  <?="onclick=\"loadURL('/recipe/open/" . $recipe['id'] . "')\""?>><img class="recipe-img" src= <?php if(isset($recipe['thumbnail'])) echo "\"" . $recipe['thumbnail'] . "\"";else echo "\"img/no_img.png\""; ?>></a>
        </div>
        <div class="col-sm-12 info">
            <div class="col-sm-12 recipe-name">
                <h4><?=$recipe['name']?></h4>
            </div>
            <div class="col-sm-12 recipe-chef-name">
                <?php if(isset($recipe['chef_name'])){ echo '<a href="/chef/profile/' . $recipe['chef_name'] . '"><h5>' . $recipe['chef_name'] . '</h5></a>';}else echo "<h5>" . $lang['No_Chef'] . "</h5>";?>
            </div>
            <div class="col-sm-6">
                <span class="glyphicon glyphicon-time"> </span><?=$recipe['time'];?>
            </div>
            <div class="col-sm-6">
                <!-- Gör en fin stjärnrad som fylls med score -->
            </div>
        </div>
    </div>
    <?php
}
?>