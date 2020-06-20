<?php

namespace FaithGen\News\Http\Controllers;

use FaithGen\News\Http\Requests\CreateRequest;
use FaithGen\News\Http\Requests\GetRequest;
use FaithGen\News\Http\Requests\UpdateImageRequest;
use FaithGen\News\Http\Requests\UpdateRequest;
use FaithGen\News\Http\Resources\Lists\News as ListResource;
use FaithGen\News\Http\Resources\News as NewsResource;
use FaithGen\News\Jobs\MessageFollowers;
use FaithGen\News\Jobs\ProcessImage;
use FaithGen\News\Jobs\S3Upload;
use FaithGen\News\Jobs\UploadImage;
use FaithGen\News\Models\News;
use FaithGen\News\Services\NewsService;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Http\Requests\CommentRequest;
use FaithGen\SDK\Http\Requests\IndexRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Helper;
use InnoFlash\LaraStart\Traits\APIResponses;

class NewsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, APIResponses, DispatchesJobs;
    /**
     * @var NewsService
     */
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Lists news items.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        $news = auth()->user()->news()
            ->latest()
            ->where(fn ($news) => $news->search(['title', 'created_at'], $request->filter_text))
            ->with(['image'])
            ->exclude(['news'])
            ->paginate(Helper::getLimit($request));

        ListResource::wrap('news');

        return ListResource::collection($news);
    }

    /**
     * Creates news article.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        return $this->newsService->createFromParent($request->validated(), 'Article created successfully!');
    }

    /**
     * Fetches an article.
     *
     * @param News $news
     * @return NewsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function view(News $news)
    {
        $this->authorize('view', $news);

        NewsResource::withoutWrapping();

        return new NewsResource($news);
    }

    /**
     * Delete a news article.
     *
     * @param GetRequest $request
     * @return mixed
     */
    public function delete(GetRequest $request)
    {
        return $this->newsService->destroy('News article deleted');
    }

    /**
     * Update an article.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(UpdateRequest $request)
    {
        return $this->newsService->update($request->validated(), 'News updated successfully');
    }

    /**
     * Update news picture.
     *
     * @param UpdateImageRequest $request
     * @return mixed
     */
    public function updatePicture(UpdateImageRequest $request)
    {
        $this->newsService->deleteFiles($this->newsService->getNews());
        try {
            MessageFollowers::withChain([
                new UploadImage($this->newsService->getNews(), $request->image),
                new ProcessImage($this->newsService->getNews()),
                new S3Upload($this->newsService->getNews()),
            ])->dispatch($this->newsService->getNews());

            return $this->successResponse('News banner updated successfully!');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Comments an article.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(CommentRequest $request)
    {
        return CommentHelper::createComment($this->newsService->getNews(), $request);
    }

    /**
     * Gets article comments.
     *
     * @param Request $request
     * @param News $news
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function comments(Request $request, News $news)
    {
        $this->authorize('view', $news);

        return CommentHelper::getComments($news, $request);
    }
}
