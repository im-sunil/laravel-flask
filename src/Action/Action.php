<?php
namespace Action;

use ArrayAccess;
use ArrayObject;
use JsonSerializable;
use Illuminate\Container\Container;

class Action implements ArrayAccess, JsonSerializable
{
    use DelegatesToAction;

    public $action;
    public $additional  = [];
    public $actionTypes = [
        "Get",
        "Paginate",
        "All",
        "Create",
        "Store",
        "Update",
        "Delete",
        "Sync",
        "Show",
        "Action",
        "Or",
        "Action",
        "And",
        "Upload",
        "Import",
    ];

    public function __construct($action = null)
    {
        $this->action = $this->setAction($action);
        sizeof(func_get_args()) == 1 ? null : $this->additional(func_get_arg(1));
    }

    public function resolve($request = null)
    {
        $data = $this->perform(
            $request = $request ?: Container::getInstance()->make('request')
        );
        return $data;
    }

    public function additional(array $additionals)
    {
        $formatadditionals = [];
        foreach ($additionals as $key => $additional) {
            $formatadditionals[$key] = is_string($additional) ? new $additional() : $additional;
        }
        $this->additional = new ArrayObject($formatadditionals, ArrayObject::ARRAY_AS_PROPS);

        /*  foreach ($this->additional as $key => $value) {
        $this->{$key} = $value;
        }*/
        return $this;
    }

    public function perform($request)
    {
        return $this->action;
    }

    public function jsonSerialize()
    {
        return $this->action;
    }

    public function __invoke()
    {
        return $this->resolve(Container::getInstance()->make('request'));
    }

    public function guessModelName()
    {
        $model = array_values(
            array_diff(
                $this->splitNameSpace($this->classBasename($this)), $this->actionTypes
            )
        );

        return config("action.model_namespcae") . "\\" . implode("", $model);
    }

    public function splitNameSpace($input)
    {
        return preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
            $input,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );
    }

    public function setAction($action = null)
    {
        if (is_null($action)) {
            return $this->guessModelName();
        }
        return is_string($action) ? new $action() : $action;
    }

    private function classBasename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
