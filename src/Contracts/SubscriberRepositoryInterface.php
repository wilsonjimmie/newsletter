<?php

namespace WilsonCreative\Newsletter\Contracts;


interface SubscriberRepositoryInterface
{
    public function all($list_id, $page = 1);

    public function find(array $data);

    public function create(array $data);

    public function update(array $data);

    public function delete(array $data);

}