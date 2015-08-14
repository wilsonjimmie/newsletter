<?php


namespace WilsonCreative\Newsletter\Contracts;


interface NewsletterRepositoryInterface
{
    public function all($page = 1);

    public function find($id);

    public function create(array $data);

    public function update(array $data);

    public function delete($id);

}