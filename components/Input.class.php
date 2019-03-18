<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 19-03-2019
 * Time: 03:16 AM
 */

class Input extends Tag
{
    private $type, $placeholder, $preFilledValue;
    public function __construct(string $type, string $placeholder, string $preFilledValue = "")
    {
        parent::__construct();
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->preFilledValue = $preFilledValue;
    }
    public function getTagComponent()
    {
        $class = implode(" ", $this->classList);
        return <<<INPUT
<input type="{$this->type}" placeholder="{$this->placeholder}" value="{$this->preFilledValue}" class="{$class}">
INPUT;
    }
}