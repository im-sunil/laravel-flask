<?php

namespace Action;

use Illuminate\Support\Facades\Facade;

/**
 * @see
 */
class ActionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'action';
    }
}
