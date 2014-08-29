<?php
namespace ip\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Router\Http\TreeRouteStack as Router;
use Zend\Http\Request;
use Zend\Mvc\Router\Http\RouteMatch;
class ListViewToolbar extends AbstractHelper{
	protected $router;
    protected $request;
    protected $viewTemplate;
    protected $allowedFilters;

    public function __construct(Router $router, Request $request){
        $this->router = $router;
        $this->request = $request;
        $this->viewTemplate = "/toolbar/listview";
    }
    protected function _getFilterRoute($statusFilter = 'all'){
        $routeMatch = $this->router->match($this->request);

        if (in_array($statusFilter, $this->allowedFilters)) {
            $routeMatch->setParam('status', $statusFilter);
        } else {
            $routeMatch->setParam('status', 'all');
        }

        return $this->router->assemble(
            $routeMatch->getParams(), 
            array('name' => $routeMatch->getMatchedRouteName())
        );
    }
    public function __invoke($searchPlaceholder, $newItemName, $newItemRoute){    
        return $this->getView()->render($this->viewTemplate, array(
            'activeFilterLink' => $this->_getFilterRoute(
               $statusFilter = 'active'
            ),
        ));
    }
}