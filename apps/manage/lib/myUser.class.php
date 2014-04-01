<?php

class myUser extends sfBasicSecurityUser
{
    function signIn($user)
    {
        $this->setAuthenticated(true);
       
        $this->setAttribute('user_id', $user->getId());
        $this->setAttribute('user',$user);

    }

    function signOut()
    {
        $this->setAuthenticated(false);
        $this->shutdown();
    }
    public function getId()
    {
        return $this->getAttribute('user_id', 0);
    }
    public function getAdminUser()
    {
        return $this->getAttribute('user', new User);
    }
}
