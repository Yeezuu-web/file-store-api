<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Gate;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RoleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), HttpFoundationResponse::HTTP_FORBIDDEN, '403 Forbidden');

        return RoleResource::collection(Role::all());
    }
}
