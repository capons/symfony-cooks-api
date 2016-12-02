<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 21.08.2016
 * Time: 23:22
 */

namespace AppBundle\Controller;
use AppBundle\Exception\WrongOrderTypeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController  extends Controller
{
    public $currentUser;
    public $input;

    private $defaultLimit = 20;
    private $defaultOffset = 0;
    
    protected function getOrderParameters(Request $request, $possibleValues)
    {
        if ($request->get('sort')) {
            $filters = [];
            foreach($request->get('sort') as $field=>$direction) {
                if (!in_array($field, $possibleValues)) {
                    throw new WrongOrderTypeException($possibleValues);
                }
                if ($direction) $filters[$field] = $direction;
            }
            return $filters;
        } else {
            return [];
        }
    }

    protected function getPaginationParameters(Request $request)
    {
        $result = [];
        if ($request->get('limit')) {
            $result['limit'] = (int) $request->get('limit');
        } else {
            $result['limit'] = $this->defaultLimit;
        }
        
        if ($request->get('offset')) {
            $result['offset'] = (int) $request->get('offset');
        } else {
            $result['offset'] = $this->defaultOffset;
        }
        
        return $result;
    }
    
    protected function getFilterParameters(Request $request, $possibleValues)
    {
        $result = [];
        if (!($filters = $request->get('filter'))) {
            return $result;
        }
        
        foreach($filters as $key=>$filter) {
            if ((!in_array($key, $possibleValues)) || (empty($filter))) {
                continue;
            }
            $result[$key] = $filter;
        }
        
        return $result;
    }
    
    protected function response($data, $code = 200)
    {
        return $this->get('resp')->resp($data, $code);
    }

}