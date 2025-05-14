<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class UserRoleMenuFilter implements FilterInterface
{
    public function transform($item)
    {
       if (isset($item['roles'])) {
        $userRoles = auth()->user()->roles()->pluck('name')->toArray();
        
        if (!array_intersect($item['roles'], $userRoles)) {
            return false;
        }
    }

    return $item;
    }
}