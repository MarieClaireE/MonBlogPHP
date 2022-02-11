<?php
require_once './class/manager/UserManager.php';
require_once './class/entity/Users.php';
require './include/cnx.php';

class IndexController
{
    public function message(Users $user)
    {
        $manager = new UserManager($user);
        $users = $manager->readAllUser();

        $userTab = [];

        foreach ($users as $user) {
            $userTab[$user->getId()] = $user;
        }

        return $userTab;
    }
}
