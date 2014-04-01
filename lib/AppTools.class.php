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
class AppTools {
    public static function getYearMonthText($date)
    {
        $time = strtotime($date);
        $newformat = date('Y-m',$time);
        return $newformat;
    }
    public static function getStaticDomain()
    {
        $domain = $_SERVER['SERVER_NAME'];
        $domain_array = explode(".", $domain);
        $extension = $domain_array[ count($domain_array) - 1 ];
        $domain_clear = $domain_array[ count($domain_array) - 2 ];
        //return 'static.'.$domain_clear.'.'.$extension;
        return sfConfig::get('app_domain_static_url');
    }
    
    public static function getClassnameByTable($table_name)
    {
        $word = $table_name;
        $word = str_replace("_"," ",$word);
        $word = ucwords($word);
        $word = str_replace(" ","",$word);
        
        return $word;
    }
    public static function display_options($pages, $level) {
        global $options;
        foreach ($pages as $page) {
            for ($space = '', $i = 1; $i <= $level; $i++) {
                $space .= '&nbsp;&nbsp;&nbsp;';
            }
            $options[$page->getId()] = $space . $page->getTitle();

            $child_pages = Doctrine::getTable('Page')->findBy('parent_id', $page->getId());
            if (count($child_pages) > 0) {
                self::display_options($child_pages, $level + 1);
            }
        }
    }
    public static function display_category($categories, $level, $model_name) {
        global $category_options;
        foreach ($categories as $category) {
            for ($space = '', $i = 1; $i <= $level; $i++) {
                $space .= '&nbsp;&nbsp;&nbsp;';
            }
            $category_options[$category->getId()] = $space . $category->getTitle();

            $child_categories = Doctrine::getTable('Category')->findBy('parent_id', $category->getId());
            if (count($child_categories) > 0) {
                self::display_category($child_categories, $level + 1, $model_name);
            }
        }
    }
    public static function getCategoryIds($model_name, $model_id)
    {
        $result = Doctrine_Core::getTable('CategoryContent')
                ->createQuery('a')
                ->where('a.model_name=?', $model_name)
                ->andWhere('a.model_id=?', $model_id)
                ->execute();
        
        $ids = array();
        foreach($result as $category)
        {
            $ids[] = $category->getCategoryId();
        }
        return $ids;
    }


    public static function url_slug($str, $options = array()) {
            // Make sure string is in UTF-8 and strip invalid UTF-8 characters
            $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

            $defaults = array(
                    'delimiter' => '-',
                    'limit' => null,
                    'lowercase' => true,
                    'replacements' => array(),
                    'transliterate' => true,
            );

            // Merge options
            $options = array_merge($defaults, $options);

            $char_map = array(
                    // Latin
                    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
                    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
                    'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
                    'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
                    'ß' => 'ss', 
                    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
                    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
                    'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
                    'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
                    'ÿ' => 'y',

                    // Latin symbols
                    '©' => '(c)',

                    // Greek
                    'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
                    'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
                    'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
                    'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
                    'Ϋ' => 'Y',
                    'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
                    'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
                    'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
                    'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
                    'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

                    // Turkish
                    'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
                    'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

                    // Mongolian / Russian
                    'А' => 'А', 'Б' => 'Б', 'В' => 'В', 'Г' => 'Г', 'Д' => 'Д', 'Е' => 'Е', 'Ё' => 'Ё', 'Ж' => 'Ж',
                    'З' => 'З', 'И' => 'И', 'Й' => 'Й', 'К' => 'К', 'Л' => 'Л', 'М' => 'М', 'Н' => 'Н', 'О' => 'О', 'Ө' => 'Ө',
                    'П' => 'П', 'Р' => 'Р', 'С' => 'С', 'Т' => 'Т', 'У' => 'У', 'Ү' => 'Ү' , 'Ф' => 'Ф', 'Х' => 'Х', 'Ц' => 'Ц',
                    'Ч' => 'Ч', 'Ш' => 'Ш', 'Щ' => 'Щ', 'Ъ' => 'Ъ', 'Ы' => 'Ы', 'Ь' => 'Ь', 'Э' => 'Э', 'Ю' => 'Ю',
                    'Я' => 'Я',
                    'а' => 'а', 'б' => 'б', 'в' => 'в', 'г' => 'г', 'д' => 'д', 'е' => 'е', 'ё' => 'ё', 'ж' => 'ж',
                    'з' => 'з', 'и' => 'и', 'й' => 'й', 'к' => 'к', 'л' => 'л', 'м' => 'м', 'н' => 'н', 'о' => 'о','ө' => 'ө',
                    'п' => 'п', 'р' => 'р', 'с' => 'с', 'т' => 'т', 'у' => 'у', 'ү' => 'ү', 'ф' => 'ф', 'х' => 'х', 'ц' => 'ц',
                    'ч' => 'ч', 'ш' => 'ш', 'щ' => 'щ', 'ъ' => 'ъ', 'ы' => 'ы', 'ь' => 'ь', 'э' => 'э', 'ю' => 'ю',
                    'я' => 'я',

                    // Ukrainian
                    'Є' => 'Є', 'І' => 'I', 'Ї' => 'Ү', 'Ґ' => 'G',
                    'є' => 'є', 'і' => 'i', 'ї' => 'ү', 'ґ' => 'g',

                    // Czech
                    'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
                    'Ž' => 'Z', 
                    'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
                    'ž' => 'z', 

                    // Polish
                    'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
                    'Ż' => 'Z', 
                    'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
                    'ż' => 'z',

                    // Latvian
                    'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
                    'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
                    'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
                    'š' => 's', 'ū' => 'u', 'ž' => 'z'
            );

            // Make custom replacements
            $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

            // Transliterate characters to ASCII
            if ($options['transliterate']) {
                    $str = str_replace(array_keys($char_map), $char_map, $str);
            }

            // Replace non-alphanumeric characters with our delimiter
            $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

            // Remove duplicate delimiters
            $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

            // Truncate slug to max. characters
            $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

            // Remove delimiter from ends
            $str = trim($str, $options['delimiter']);

            return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
    
      
    public static function switchListitem($model_name, $item_id, $move_to, $parameters)
    {
        $page = Doctrine_Core::getTable($model_name)->find($item_id);
        $dest = Doctrine::getTable($model_name)->createQuery('a');
        
        switch ($move_to)
        {
            case 'up':
                $dest = $dest->where('a.sort < '. $page->getSort());
                break;
            case 'down':
                $dest = $dest->where('a.sort > '. $page->getSort());
                break;
            default:
                exit;
        }
        foreach($parameters as $key => $parameter)
        {
            $dest = $dest->andWhere("a.".$key."=". "'".$parameter."'");
        }
        $dest = $dest->andWhere('a.parent_id='.$page->getParentId());
        
        switch ($move_to)
        {
            case 'up':
                $dest = $dest->orderBy('a.sort DESC');
                break;
            case 'down':
                $dest = $dest->orderBy('a.sort ASC');
                break;
            default:
                exit;
        }
        $query = $dest;
        $dest = $dest->fetchOne();
        
        //sfContext::getInstance()->getUser()->setFlash('alert', 'danger');
        //sfContext::getInstance()->getUser()->setFlash('message', $query.' '.$dest.'&'.$page);
        
        if($dest)
        {
            $temp_sort = $dest->getSort();

            $dest->setSort($page->getSort());
            $dest->save();

            $page->setSort($temp_sort);
            $page->save();
        }
    }
    public static function getCategories($model_name, $model_id)
    {
        $category_contents = Doctrine::getTable('CategoryContent')
                ->createQuery('a')
                ->where('a.model_name=?', $model_name)
                ->andWhere('a.model_id=?', $model_id)
                ->execute();
        
        $category_ids = array();
        
        foreach($category_contents as $category_content)
        {
            $category_ids [] = $category_content->getCategoryId();
        }
        
        if(count($category_ids) == 0)
        {
            $category_ids[] = '0';
        }
        
        $categories = Doctrine::getTable('Category')
                ->createQuery('a')
                ->whereIn('a.id', $category_ids)
                ->execute();
        
        return $categories;
    }    

}

?>
