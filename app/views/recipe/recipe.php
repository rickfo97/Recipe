<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-04
 * Time: 16:40
 */
?>
<div class="col-md-3 ingredients">
    <ul class="recipe-step-ingredient">
        <?php
        $ingredients = explode(' | ', $data['steps'][0]['ingredients']);
        foreach ($ingredients as $ingredient) {
            ?>
            <li>
                <?=$ingredient?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
<div class="col-md-9 steps">
    <ol class="recipe-step">
        <?php
        foreach ($data['steps'] as $step) {
            ?>
            <li class="well">
                <?= $step['step'] ?>
            </li>
            <?php
        }
        ?>
    </ol>
</div>