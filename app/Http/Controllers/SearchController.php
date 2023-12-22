<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var SearchService
     */
    private $searchService;

    /**
     * SearchController constructor.
     *
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request) 
    {
        return view('client.search', $this->searchService->search($request));
    }
}
