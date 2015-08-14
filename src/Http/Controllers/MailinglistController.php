<?php

namespace WilsonCreative\Newsletter\Http\Controllers;

use WilsonCreative\Newsletter\Contracts\MailinglistRepositoryInterface;
use WilsonCreative\Newsletter\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;


class MailinglistController extends BaseController
{
    protected $mailinglist;

    public function __construct(MailinglistRepositoryInterface $mailinglist)
    {
        $this->mailinglist = $mailinglist;
    }

    public function index(Request $request)
    {
        return $this->mailinglist->all($request->input('page'));
    }

    public function show($id)
    {
        return $this->mailinglist->find($id);
    }

    public function store(array $newsletter)
    {
        return $this->mailinglist->create($newsletter);
    }

    public function update(array $newsletter)
    {
        return $this->mailinglist->update($newsletter);
    }

    public function destroy($id)
    {
        return $this->mailinglist->delete($id);
    }
}