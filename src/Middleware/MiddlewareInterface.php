<?php

namespace Luminar\Http\Middleware;

use Luminar\Http\Request;
use Luminar\Http\Response;

interface MiddlewareInterface
{
    /**
     * This function can return Response if middleware want to stop request or something like that, if not function
     * need to just return null and anything will happen
     *
     * @param Request $request
     * @return Response|null
     */
    public function run(Request $request): Response|null;
}