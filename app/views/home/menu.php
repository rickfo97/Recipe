<?php
include '../app/language/sv.php';
$activeMenu = '';
if (isset($_GET['url'])) {
    if (strpos($_GET['url'], 'user') !== false)
        $activeMenu = 'user';
    if (strpos($_GET['url'], 'admin') !== false)
        $activeMenu = 'admin';
}
$menuClass = "tab-pane fade";
?>
<div class="col-sm-3 sidenav">
    <ul class="nav nav-tabs nav-justified">
        <li <?php if($activeMenu == '') echo "class='active'";?>><a data-toggle="tab"
               href="#standardMenu"><?= $lang['Menu_Title'] ?></a>
        </li>
        <?php if (isset($data['user'])) { ?>
            <li <?php if($activeMenu == 'user') echo "class='active'";?>><a data-toggle="tab"
                   href="#userMenu"><?= $data['user']['username'] ?></a>
            </li><?php ?>
            <?php if ($data['user']['permission'] >= 15) { ?>
                <li <?php if($activeMenu == 'admin') echo "class='active'";?>><a data-toggle="tab"
                       href="#adminMenu"><?= $lang['Menu_Admin'] ?></a>
                </li><?php }
        } else { ?>
            <li <?php if($activeMenu == 'user') echo "class='active'";?>><a data-toggle="tab" href="#userMenu"><?= $lang['Menu_User'] ?></a>
            </li>
            <?php
        }
        ?>
    </ul>

    <div class="tab-content">
        <div id="standardMenu" <?php if($activeMenu == '') echo "class='$menuClass active in'"; else echo "class='$menuClass'"?>>
            <ul class="nav nav-pills nav-stacked">
                <li><a onclick="loadURL('/')"><?= $lang['Menu_Home'] ?></a></li>
                <li><a onclick="loadURL('/recipe/latest')"><?= $lang['Menu_New'] ?></a></li>
                <li><a onclick="loadURL('/recipe/top')"><?= $lang['Menu_Top'] ?></a></li>
                <li><a onclick="loadURL('/recipe/ingredient')"><?= $lang['Menu_Ingredient'] ?></a></li>
            </ul>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" placeholder=<?= "\"" . $lang['Menu_Search'] . "\"" ?>>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
        <?php
        if (isset($data['user'])) {
            ?>
            <div id="userMenu" <?php if($activeMenu == 'user') echo "class='$menuClass active in'"; else echo "class='$menuClass'"?>>
                <ul class="nav nav-pills nav-stacked">
                    <li><a onclick="loadURL('/user/profile')"><?= $lang['Menu_User_Profile'] ?></a></li>
                    <li><a onclick="loadURL('/user/bookmark')"><?= $lang['Menu_User_Bookmark'] ?></a></li>
                    <li><a onclick="loadURL('/recipe/upload')"><?= $lang['Menu_User_Upload'] ?></a></li>
                    <li><a onclick="loadURL('/user/logout')"><?= $lang['Menu_User_Logout'] ?></a></li>
                </ul>
            </div>
            <?php
            if ($data['user']['permission'] >= 15) {
                ?>
                <div id="adminMenu" <?php if($activeMenu == 'admin') echo "class='$menuClass active in'"; else echo "class='$menuClass'"?>>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a onclick="loadURL('/admin/dashboard')"><?= $lang['Menu_Admin_Dashboard'] ?></a></li>
                        <li><a onclick="loadURL('/admin/statistics')"><?= $lang['Menu_Admin_Statistics'] ?></a></li>
                    </ul>
                </div>
                <?php
            }
        } else {
            ?>
            <div id="userMenu" <?php if($activeMenu == 'user') echo "class='$menuClass active in'"; else echo "class='$menuClass'"?>>
                <ul class="nav nav-pills nav-stacked">
                    <li><a onclick="loadURL('/user/login')"><?= $lang['Menu_User_Login'] ?></a></li>
                    <li><a onclick="loadURL('/user/register')"><?= $lang['Menu_User_Register'] ?></a></li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>