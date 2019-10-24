<?php

namespace FaithGen\News\Http\Controllers;

use App\Http\Controllers\Controller;
use FaithGen\News\Events\Saved;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\News\Http\Requests\News\CreateRequest;
use FaithGen\News\Http\Requests\News\GetRequest;
use FaithGen\News\Http\Requests\News\UpdateImageRequest;
use FaithGen\News\Http\Requests\News\UpdateRequest;
use FaithGen\News\Http\Resources\Lists\News as ListResource;
use FaithGen\News\Http\Resources\News as NewsResource;
use FaithGen\News\Models\News;
use FaithGen\News\Services\NewsService;

class NewsController extends Controller
{
    /**
     * @var NewsService
     */
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    function index(IndexRequest $request)
    {
        $news = $this->newsService->getParentRelationship()
            ->with(['image'])
            ->where('title', 'LIKE', '%' . $request->filter_text . '%')
            ->orWhere('created_at', 'LIKE', '%' . $request->filter_text . '%')
            ->latest()
            ->paginate($request->has('limit') ? $request->limit : 15);
        return $news;
        return ListResource::collection($news);
    }

    function create(CreateRequest $request)
    {
        return $this->newsService->createFromRelationship($request->validated(), 'Article created successfully!');
    }

    function view($news)
    {
        $theNews = News::findOrFail($news);
        auth()->user()->can('news.view', $theNews);
        NewsResource::withoutWrapping();
        return new NewsResource($theNews);
    }

    function delete(GetRequest $request)
    {
        return $this->newsService->destroy('Requests deleted');
    }

    function update(UpdateRequest $request)
    {
        return $this->newsService->update($request->validated(), 'Requests updated successfully');
    }

    function updatePicture(UpdateImageRequest $request)
    {
        $this->newsService->deleteFiles($this->newsService->getNews());
        try {
            event(new Saved($this->newsService->getNews()));
            return $this->successResponse('Requests banner updated successfully!');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
