<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppTools
 *
 * @author Administrator
 */
class AppConstants {
    public static function getDeleteCurrentImage()
    {
        return 'Ашиглаж байгаа файлыг устгах';
    }
    public static function getBooleanChoice($choice = true)
    {
        if($choice) return array('1' => 'Тийм', '0' => 'Үгүй');
        else return array( '0' => 'Үгүй', '1' => 'Тийм');
    }
    public static function getRequiredText()
    {
        return 'Заавал оруулна уу!';
    }
    public static function getBooleanIcon($value)
    {
        return $value ? '<i class="fa fa-check-square-o"></i>' : '<i class="fa fa-square-o"></i>';
    }
    public static function getUser($user_id)
    {
        $user = Doctrine_Core::getTable('User')->find($user_id);
        
        if($user)
            return $user;
        else
            return new User();
    }
    public static function getUserRole($role_id)
    {
        $role = Doctrine_Core::getTable('UserRole')->find($role_id);
        
        if($role)
            return $role;
        else
            return new UserRole();
    }
    public static function getQuoteAuthorType($type_id)
    {
        $type = Doctrine_Core::getTable('QuoteAuthorType')->find($type_id);
        
        if($type)
            return $type;
        else
            return new QuoteAuthorType();
    }
    public static function getQuoteAuthor($author_id)
    {
        $author = Doctrine_Core::getTable('QuoteAuthor')->find($author_id);
        
        if($author)
            return $author;
        else
            return new QuoteAuthor();
    }
    public static function getQuoteCategory($category_id)
    {
        $category = Doctrine_Core::getTable('QuoteCategory')->find($category_id);
        
        if($category)
        {
            return $category;
        }
        else
        {
            return new QuoteCategory();
        }
    }
    public static function getFilterUrl($internal_url, $whereArray , $filterArray)
    {
      foreach($filterArray as $field=>$value)
      {
        $whereArray [$field] = $value;
      }
      foreach($whereArray as $field => $value)
      {
        $internal_url .= '/'.$field.'/'.$value;
       
      }
      return $internal_url;
    }
}

?>
