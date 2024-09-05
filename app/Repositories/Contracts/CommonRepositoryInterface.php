<?php
namespace App\Repositories\Contracts;

interface CommonRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByField($field, $value);
    public function createOrUpdateByField($field, $value, $data);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

}