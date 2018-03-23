<?php

function perform($action, ...$parameters)
{
    return (
        is_string($action) ? (new $action(...$parameters))() : $action()
    );
}
