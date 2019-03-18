<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 19-03-2019
 * Time: 03:04 AM
 */

abstract class Tag
{
    protected $classList;
    private $count;
    protected $id;
    public function __construct()
    {
        $this->classList = array();
        $this->count = 0;
    }

    public abstract function getTagComponent();
    public function addClass($classname)
    {
        $this->classList[$this->count++] = $classname;
    }

    public function setId($id){
        $this->id = $id;
    }
}