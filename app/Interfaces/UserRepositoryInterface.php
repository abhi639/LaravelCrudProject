<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function index();
    public function getbyid($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);

}
