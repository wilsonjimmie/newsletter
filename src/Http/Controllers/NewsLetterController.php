<?php

namespace WilsonCreative\Newsletter\Http\Controllers;

use WilsonCreative\Newsletter\Contracts\NewsletterRepositoryInterface;
use WilsonCreative\Newsletter\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class NewsLetterController extends BaseController
{

    protected $newsletter;

    public function __construct(NewsletterRepositoryInterface $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function index(Request $request)
    {
        return $this->newsletter->all($request->input('page'));
    }

    public function show($id)
    {
        return $this->newsletter->find($id);
    }

    public function store(array $newsletter)
    {
        return $this->newsletter->create($newsletter);
    }

    public function update(array $newsletter)
    {
        return $this->newsletter->update($newsletter);
    }

    public function destroy($id)
    {
        return $this->newsletter->delete($id);
    }

}