<?php

namespace FaithGen\News\Http\Controllers;

use FaithGen\News\Models\News;
use FaithGen\News\Events\Saved;
use App\Http\Controllers\Controller;
use InnoFlash\LaraStart\Http\Helper;
use FaithGen\News\Services\NewsService;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\News\Http\Requests\CommentRequest;
use FaithGen\News\Http\Requests\News\GetRequest;
use FaithGen\News\Http\Requests\News\CreateRequest;
use FaithGen\News\Http\Requests\News\UpdateRequest;
use FaithGen\News\Http\Resources\News as NewsResource;
use FaithGen\News\Http\Requests\News\UpdateImageRequest;
use FaithGen\News\Http\Resources\Lists\News as ListResource;
use Illuminate\Http\Request;

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
        $news =  auth()->user()->news()
            ->with(['image'])
            ->where('title', 'LIKE', '%' . $request->filter_text . '%')
            ->orWhere('created_at', 'LIKE', '%' . $request->filter_text . '%')
            ->latest()
            ->paginate(Helper::getLimit($request));
        return ListResource::collection($news);
    }

    function create(CreateRequest $request)
    {
        return $this->newsService->createFromParent($request->validated(), 'Article created successfully!');
    }

    function view(News $news)
    {
        $this->authorize('news.view', $news);
        NewsResource::withoutWrapping();
        return new NewsResource($news);
    }

    function delete(GetRequest $request)
    {
        return $this->newsService->destroy('News article deleted');
    }

    function update(UpdateRequest $request)
    {
        return $this->newsService->update($request->validated(), 'News updated successfully');
    }

    function updatePicture(UpdateImageRequest $request)
    {
        $this->newsService->deleteFiles($this->newsService->getNews());
        try {
            event(new Saved($this->newsService->getNews()));
            return $this->successResponse('News banner updated successfully!');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function comment(CommentRequest $request)
    {
        return CommentHelper::createComment($this->newsService->getNews(), $request);
    }

    public function comments(Request $request, News $news)
    {
        $this->authorize('news.view', $news);
        return CommentHelper::getComments($news, $request);
    }
}
