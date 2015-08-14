<?php

namespace WilsonCreative\Newsletter\Http\Controllers;

use WilsonCreative\NewsLetter\Contracts\SubscriberRepositoryInterface;
use WilsonCreative\Newsletter\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class SubscriberController extends BaseController
{

    protected $subscriber;

    public function __construct(SubscriberRepositoryInterface $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function index($list_id, Request $request)
    {
        return $this->subscriber->all($list_id, $request->input('page'));
    }

    public function show($list_id, $email)
    {
        return $this->subscriber->find(['email' => $email, 'list_id' => $list_id]);
    }

    public function store(Request $request)
    {
        return $this->subscriber->create($request->all());
    }

    public function update(Request $request)
    {
        return $this->subscriber->update($request->all());
    }

    public function destroy($list_id, $email)
    {
        return $this->subscriber->delete(['email' => $email, 'list_id' => $list_id]);
    }

    public function create($list_id)
    {
        return view('subscriber.create')->with('list_id', $list_id);
    }

    public function edit($list_id, $email)
    {
        return view('subscriber.edit')->with(['list_id' => $list_id, 'email' => $email]);
    }

}