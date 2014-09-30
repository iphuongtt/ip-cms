<?php
namespace Ip\View\Helper;
use Zend\View\Helper\AbstractHelper;
class rowAction extends AbstractHelper
{
    public function __invoke($id)
    {	$htmlStr = '';
    	$htmlStr = '
        <div class="rowActions">
        	<span class="edit"><a href="">Sửa</a> | </span>
        	<span class="inline hide-if-no-js"><a class="editinline" href="#">Sửa nhanh</a> | </span>
        	<span class="delete"><a href="" class="delete-tag">Xóa</a> | </span>
        	<span class="view"><a href="">Xem</a></span></div>
        ';
        return $htmlStr;
    }
}