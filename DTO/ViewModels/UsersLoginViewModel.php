<?php

namespace DTO\ViewModels;

class UsersLoginViewModel
{

    private $error;

    /**
     * @param $error
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }


}