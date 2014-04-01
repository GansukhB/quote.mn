<?php

class Auth {
    public static function getCheckUser($email, $password)
    {
        $user = Doctrine::getTable('User')
                ->createQuery('u')
                ->where('u.email = ?', $email)
                ->andWhere('u.password = ?', md5($password))
                ->fetchOne();
        
        return $user;
    }
    public static function getUserRoles($user_id)
    {
        $role_set = Doctrine_Query::create()
                ->from('UserRole ur')
                ->where('ur.id IN (SELECT ua.role_id FROM UserAdmin ua WHERE ua.user_id = ? )', $user_id);
        //echo $role_set;
        $roles = $role_set->fetchArray();
        
        return $roles;
    }
}

?>
