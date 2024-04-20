<?php

namespace App\Modules\Base\Repositories;

/**
 * Class CoreRepositories
 * Ядро для других репозиториев
 *
 * @package App/Modules/Base/Repositories
 *
 * Репозиторий для работы с сущностью
 * Может выдавать наборы данных
 * Не может создавать/изменять сущность - выборка данных
 *
 */
abstract class CoreRepositories
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepositories constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Model|\Illuminate\Foundation\Application\mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }

}



