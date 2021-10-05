<?php

namespace ReactphpQuerylist;

use Psr\Http\Message\ResponseInterface;
use QL\QueryList;

class Queryable
{
    protected ResponseInterface $response;
    protected QueryList $queryList;


    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->queryList = QueryList::getInstance()->setHtml($response->getBody()->getContents());
    }

    /**
     * @return QueryList
     */
    public function queryList(): QueryList
    {
        return $this->queryList;
    }

    /**
     * @return ResponseInterface
     */
    public function response(): ResponseInterface
    {
        return $this->response;
    }
}