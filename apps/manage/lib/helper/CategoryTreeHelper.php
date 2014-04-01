<?php
    function getModuleCategoryTree( $module_name, $module_list)
    {
        global $page_html;
        
        ModuleCategoryDFSTree(null, $module_name, $module_list);
        
        return $page_html;
    }
    function ModuleCategoryDFSTree($root, $module_name, $module_list)
    {
        global $page_html;

        $childs = array();

        foreach($module_list as $category)
        {
            if($root)
            {
                if($category->getParentId() == $root->getId())
                {
                    array_push($childs, $category);
                }
            }
            else
            {
                if($category->getParentId() == '0')
                {
                    array_push($childs, $category);
                }
            }   
        }
        $child_count = count($childs);

        if($child_count == 0 && $root)
        {
            
            $page_html .= "<li><div class=\"box-menu-list tooltip-buttons\">"
                    .'<a href="'.url_for('category/changestate?id='.$root->getId().'&field=is_active').'" class="btn btn-default"> '
                    .AppConstants::getBooleanIcon($root->getIsActive()).'</a> '.$root->getTitle()."<div class=\"pull-right\"> 
                <a href=\"". url_for('category/edit?id='.$root->getId().'&model_name=post')."\" class=\"btn btn-xs btn-warning\"  data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Засварлах\"><i class=\"fa fa-edit\"></i> Засварлах</a>
                <a href=\"". url_for('category/move?id='.$root->getId().'&to=up&model_name=post')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Дээш зөөх\">&nbsp;<i class=\"fa fa-arrow-up\"></i>&nbsp;</a>
                <a href=\"". url_for('category/move?id='.$root->getId().'&to=down&model_name=post')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"Доош зөөх\">&nbsp;<i class=\"fa fa-arrow-down\"></i>&nbsp;</a>    
                </div></div></li>";
        }
        else
        {
            if($root)
            {
                $page_html .= "<li><div class=\"box-menu-list tooltip-buttons\">".'<a href="'.url_for('category/changestate?id='.$root->getId().'&field=is_active').'" class="btn btn-default"> '
                    .AppConstants::getBooleanIcon($root->getIsActive()).'</a> '.$root->getTitle()."<div class=\"pull-right\"> 
                    <a href=\"". url_for('category/edit?id='.$root->getId().'&model_name=post')."\"  class=\"btn btn-xs btn-warning\"  data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Засварлах\"><i class=\"fa fa-edit\"></i>  Засварлах</a>
                    <a href=\"". url_for('category/move?id='.$root->getId().'&to=up&model_name=post')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"Дээш зөөх\">&nbsp;<i class=\"fa fa-arrow-up\"></i>&nbsp;</a>
                    <a href=\"". url_for('category/move?id='.$root->getId().'&to=down&model_name=post')."\" class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"Доош зөөх\">&nbsp;<i class=\"fa fa-arrow-down\"></i>&nbsp;</a>    
                    </div></div><ul>";
            }
            foreach($childs as $child)
            {
                ModuleCategoryDFSTree($child, $module_name, $module_list);
            }

            $page_html .= "</ul></li>";
        }
    }
    
    /*
     * Ялгаж харахад зориулсан Dropdown линк. Dropdown
     */
    
    function getModuleCategoryTreeDropdown($module_name, $module_list)
    {
        global $page_html;
        
        ModuleCategoryDFSTreeDropdown(null, $module_name, $module_list, -1);
        
        return $page_html;
    }
    function ModuleCategoryDFSTreeDropdown($root, $module_name, $module_list, $level)
    {
        global $page_html;

        $childs = array();

        foreach($module_list as $category)
        {
            if($root)
            {
                if($category->getParentId() == $root->getId())
                {
                    array_push($childs, $category);
                }
            }
            else
            {
                if($category->getParentId() == '0')
                {
                    array_push($childs, $category);
                }
            }   
        }
        $child_count = count($childs);

        if($child_count == 0 && $root)
        {
            
            $page_html .= '<li>'.'<a href="'.url_for('post/index?category_id='.$root->getId()).'">';
            for($i = 0; $i < $level; $i++)
            {
                $page_html .= '&nbsp;&nbsp;&nbsp;';
            }
            $page_html .= $root->getTitle().'</a></li>';
        }
        else
        {
            if($root)
            {
                $page_html .= '<li>'.'<a href="'.url_for('post/index?category_id='.$root->getId()).'">';
                for($i = 0; $i < $level; $i++)
                {
                    $page_html .= '&nbsp;&nbsp;&nbsp;';
                }
                $page_html .= $root->getTitle().'</a></li>';
            }
            foreach($childs as $child)
            {
                ModuleCategoryDFSTreeDropdown($child,  $module_name, $module_list, $level+1);
            }

        }
    }
?>
