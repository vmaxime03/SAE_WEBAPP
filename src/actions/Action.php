<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\exceptions\AuthzException;

abstract class Action {

    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;

    public function __construct(){

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    public function execute() : string {
        return match ($this->http_method) {
            'GET' => $this->get(),
            'POST' => $this->post()
        };
    }

    abstract public function get() : string;
    abstract public function post() : string;

    protected function checkVar(mixed $var, int $FILTER, array|int $option = null) : mixed {
        if (is_null($option)) {
            $f = filter_var($var, $FILTER);
        } else {
            $f = filter_var($var, $FILTER, $option);
        }
        return  ($var != "" && $var === $f) ? $var : false;
    }
    protected function checkGetInput(string $name, int $FILTER, array|int $option = null) : mixed {
        if (!isset($_GET[$name])) {return false;}
        return $this->checkVar($_GET[$name], $FILTER, $option);
    }

    protected function checkPostInput(string $name, int $FILTER, array|int $option = null) : mixed {
        if (!isset($_POST[$name])) {return false;}
        return $this->checkVar($_POST[$name], $FILTER, $option);
    }

    protected function checkAuthzStaff() : string|false
    {
        try {
            Authz::checkRoleStaff();
        } catch (AuthException $e) {
            return "Vous n'etes pas connécté";
        } catch (AuthzException $e) {
            return "Acces refusé";
        }
        return false;
    }
}