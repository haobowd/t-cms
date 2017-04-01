<?php


namespace App\Http\Controllers\Admin\Api;


use App\Entities\Permission;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Transformers\PermissionTransformer;
use Auth;

class PermissionsController extends ApiController
{
    public function menus()
    {
        $permissions = Permission::getUserMenu(Auth::user());

        $topPermissions = Permission::allPermissionWithCache();
        $topPermissions = $topPermissions->only($permissions->keys()->all())->keyBy('id')->toArray();
        foreach ($topPermissions as &$topPermission)
        {
            $topPermission['children'] = $permissions[$topPermission['id']];
        }
        unset($topPermission);
        return $topPermissions;
    }

    public function getTopPermissions()
    {
        /*return $this->response->collection(
            Permission::allPermissionWithCache()->where('parent_id', 0),
            new PermissionTransformer());*/
        $topPermissions = Permission::topPermissions()
            ->withSort()
            ->withSimpleSearch()
            ->ordered()
            ->recent()
            ->paginate($this->perPage());
        return $this->response->paginator($topPermissions, new PermissionTransformer())
            ->setMeta(Permission::getAllowSearchFieldsMeta() + Permission::getAllowSortFieldsMeta());

    }

    public function getChildren(Permission $permission)
    {
        /*$permissions = Permission::allPermissionWithCache()->where('parent_id', $permission->id);
        return $this->response->collection($permissions, new PermissionTransformer());*/
        $childrenPermissions = Permission::childrenPermissions($permission->id)
            ->withSort()
            ->withSimpleSearch()
            ->ordered()
            ->recent()
            ->paginate($this->perPage());
        return $this->response->paginator($childrenPermissions, new PermissionTransformer())
            ->setMeta(Permission::getAllowSearchFieldsMeta() + Permission::getAllowSortFieldsMeta());
    }

    public function store(PermissionCreateRequest $request)
    {
        Permission::create($request->all());
        return $this->response->noContent();
    }

    public function update(Permission $permission, PermissionUpdateRequest $request)
    {
        $request->performUpdate($permission);
        return $this->response->noContent();
    }


}