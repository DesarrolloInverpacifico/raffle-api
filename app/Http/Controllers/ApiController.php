<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\PaginateQueryBuilder;

class ApiController extends Controller
{
    use ApiResponser, PaginateQueryBuilder;
}
