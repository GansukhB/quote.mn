<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Post', 'doctrine');

/**
 * BasePost
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $front_image
 * @property string $short_body
 * @property string $body
 * @property integer $is_active
 * @property integer $is_commentable
 * @property integer $is_top
 * @property integer $is_featured
 * @property integer $count_view
 * @property integer $count_comment
 * @property integer $created_user_id
 * @property timestamp $published_at
 * @property timestamp $updated_at
 * @property timestamp $created_at
 * 
 * @method integer   getId()              Returns the current record's "id" value
 * @method integer   getCategoryId()      Returns the current record's "category_id" value
 * @method string    getTitle()           Returns the current record's "title" value
 * @method string    getFrontImage()      Returns the current record's "front_image" value
 * @method string    getShortBody()       Returns the current record's "short_body" value
 * @method string    getBody()            Returns the current record's "body" value
 * @method integer   getIsActive()        Returns the current record's "is_active" value
 * @method integer   getIsCommentable()   Returns the current record's "is_commentable" value
 * @method integer   getIsTop()           Returns the current record's "is_top" value
 * @method integer   getIsFeatured()      Returns the current record's "is_featured" value
 * @method integer   getCountView()       Returns the current record's "count_view" value
 * @method integer   getCountComment()    Returns the current record's "count_comment" value
 * @method integer   getCreatedUserId()   Returns the current record's "created_user_id" value
 * @method timestamp getPublishedAt()     Returns the current record's "published_at" value
 * @method timestamp getUpdatedAt()       Returns the current record's "updated_at" value
 * @method timestamp getCreatedAt()       Returns the current record's "created_at" value
 * @method Post      setId()              Sets the current record's "id" value
 * @method Post      setCategoryId()      Sets the current record's "category_id" value
 * @method Post      setTitle()           Sets the current record's "title" value
 * @method Post      setFrontImage()      Sets the current record's "front_image" value
 * @method Post      setShortBody()       Sets the current record's "short_body" value
 * @method Post      setBody()            Sets the current record's "body" value
 * @method Post      setIsActive()        Sets the current record's "is_active" value
 * @method Post      setIsCommentable()   Sets the current record's "is_commentable" value
 * @method Post      setIsTop()           Sets the current record's "is_top" value
 * @method Post      setIsFeatured()      Sets the current record's "is_featured" value
 * @method Post      setCountView()       Sets the current record's "count_view" value
 * @method Post      setCountComment()    Sets the current record's "count_comment" value
 * @method Post      setCreatedUserId()   Sets the current record's "created_user_id" value
 * @method Post      setPublishedAt()     Sets the current record's "published_at" value
 * @method Post      setUpdatedAt()       Sets the current record's "updated_at" value
 * @method Post      setCreatedAt()       Sets the current record's "created_at" value
 * 
 * @package    quote.mn
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePost extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('post');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('category_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('front_image', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('short_body', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('body', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('is_active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('is_commentable', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('is_top', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('is_featured', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('count_view', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('count_comment', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('created_user_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('published_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}