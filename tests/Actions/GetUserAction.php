<?php
namespace Tests\Actions;

use Action\Action;

class GetUserAction extends Action
{
    /**
     * @return mixed
     */
    public function perform($request)
    {
        $role = $this->additional->role ?? null;

        return $this;
    }
}
