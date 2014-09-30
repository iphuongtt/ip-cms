<?php
/**
 * Created by PhpStorm.
 * User: Phuong
 * Date: 09/09/2014
 * Time: 00:02
 */
namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
class testhelper extends AbstractHelper
{
    public function __invoke($str, $find)
    {
        if (! is_string($str)){
            return 'must be string';
        }

        if (strpos($str, $find) === false){
            return 'not found';
        }

        return 'found';
    }
}