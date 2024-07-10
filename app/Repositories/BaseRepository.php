<?php

// app/Repositories/BaseRepository.php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getOne($col, $value)
    {
        return $this->model->where($col, $value)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->update($data);
        }

        return false;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }

        return false;
    }
}
