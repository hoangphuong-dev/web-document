<?php

namespace App\Traits;

trait FilterSignature
{
    protected string $filters = '
    {--id= : id|latest|ranges(1-n)|list(1,2,...,n)}
    {--from= : from id}
    {--to= : to id}
    {--id_filter= : Select id by mod example 3,2 4,1 2,0}
    ';

    public function __construct()
    {
        //remember remove __construct() from parent class
        $this->signature .= $this->filters;
        parent::__construct();
    }
}
