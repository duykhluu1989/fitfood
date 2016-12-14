<?php

namespace App\Admin\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\BlogCategory;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Widget;
use Barryvdh\Elfinder\Connector;

class BlogController extends Controller
{
    public function listCategory(Request $request)
    {
        $input = $request->all();

        $builder = BlogCategory::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['name_en']))
                $builder->where('name_en', 'like', '%' . $input['filter']['name_en'] . '%');

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $categories = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.blogs.list_category', [
            'categories' => $categories,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createCategory(Request $request)
    {
        $category = new BlogCategory();
        $category->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveCategory($request, $category, 'admin.blogs.create_category');
    }

    public function editCategory(Request $request, $id)
    {
        $category = BlogCategory::find($id);

        return $this->saveCategory($request, $category, 'admin.blogs.edit_category');
    }

    protected function saveCategory($request, $category, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('category');

            $file = $request->file('image');

            $category->name = isset($input['name']) ? trim($input['name']) : '';
            $category->name_en = isset($input['name_en']) ? trim($input['name_en']) : '';
            $category->slug = isset($input['slug']) ? trim($input['slug']) : '';
            $category->slug_en = isset($input['slug_en']) ? trim($input['slug_en']) : '';
            $category->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            if(empty($category->slug))
                $category->slug = str_slug($category->name);
            else
                $category->slug = str_slug($category->slug);
            if(empty($category->slug_en))
            {
                if(!empty($category->name_en))
                    $category->slug_en = str_slug($category->name_en);
            }
            else
                $category->slug_en = str_slug($category->slug_en);

            $errors = $category->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $category->save();

                    if(!empty($file))
                    {
                        if(in_array($file->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/category';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'category_' . str_replace('.', '', microtime(true)) . '.' . strtolower($file->getClientOriginalExtension());

                            $file->move($path, $fileName);

                            Util::cropImage($path . '/' . $fileName, 1600, 505);

                            if(!empty($category->image_src))
                            {
                                $imageSrcParts = explode('/', $category->image_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $category->image_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/category/' . $fileName;
                            $category->save();
                        }
                    }

                    Db::commit();

                    return redirect('admin/blogCategory');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['category' => $category, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['category' => $category, 'errors' => $errors]);
        }

        return view($view, ['category' => $category]);
    }

    public function listArticle(Request $request)
    {
        $input = $request->all();

        $builder = Article::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['name_en']))
                $builder->where('name_en', 'like', '%' . $input['filter']['name_en'] . '%');

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $articles = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.blogs.list_article', [
            'articles' => $articles,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createArticle(Request $request)
    {
        $article = new Article();
        $article->status = Util::STATUS_ARTICLE_DRAFT_VALUE;
        $article->author = auth()->user()->username;

        return $this->saveArticle($request, $article, 'admin.blogs.create_article');
    }

    public function editArticle(Request $request, $id)
    {
        $article = Article::find($id);

        return $this->saveArticle($request, $article, 'admin.blogs.edit_article');
    }

    protected function saveArticle($request, $article, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('article');

            $file = $request->file('image');
            $thumbnail = $request->file('thumbnail');

            $article->category_id = isset($input['category_id']) ? trim($input['category_id']) : '';
            $article->name = isset($input['name']) ? trim($input['name']) : '';
            $article->name_en = isset($input['name_en']) ? trim($input['name_en']) : '';
            $article->slug = isset($input['slug']) ? trim($input['slug']) : '';
            $article->slug_en = isset($input['slug_en']) ? trim($input['slug_en']) : '';
            $article->description = isset($input['description']) ? trim($input['description']) : '';
            $article->description_en = isset($input['description_en']) ? trim($input['description_en']) : '';
            $article->body_html = isset($input['body_html']) ? trim($input['body_html']) : '';
            $article->body_html_en = isset($input['body_html_en']) ? trim($input['body_html_en']) : '';
            $article->tags = isset($input['tags']) ? trim($input['tags']) : '';
            $article->author = isset($input['author']) ? trim($input['author']) : '';
            $article->status = isset($input['status']) ? trim($input['status']) : $article->status;

            if($article->status == Util::STATUS_ARTICLE_PUBLISH_VALUE)
                $article->published_at = !empty($input['published_at']) ? trim($input['published_at']) : date('Y-m-d H:i:s');
            else
                $article->published_at = null;

            if(empty($article->slug))
                $article->slug = str_slug($article->name);
            else
                $article->slug = str_slug($article->slug);
            if(empty($article->slug_en))
            {
                if(!empty($article->name_en))
                    $article->slug_en = str_slug($article->name_en);
            }
            else
                $article->slug_en = str_slug($article->slug_en);

            $errors = $article->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    if(empty($article->id))
                    {
                        $article->view = 0;
                        $article->created_at = date('Y-m-d H:i:s');
                    }

                    if($article->getOriginal('tags') != $article->tags)
                    {
                        $oldTags = explode(';', $article->getOriginal('tags'));
                        $newTags = explode(';', $article->tags);

                        $allTags = array_unique(array_merge($oldTags, $newTags));

                        $tagModels = Tag::whereIn('name', $allTags)->get();

                        foreach($tagModels as $tagModel)
                        {
                            if(in_array($tagModel->name, $oldTags) && !in_array($tagModel->name, $newTags))
                            {
                                $tagModel->article -= 1;
                                $tagModel->save();
                            }
                            else if(!in_array($tagModel->name, $oldTags) && in_array($tagModel->name, $newTags))
                            {
                                $tagModel->article += 1;
                                $tagModel->save();
                            }

                            $key = array_search($tagModel->name, $allTags);

                            if($key !== false)
                                unset($allTags[$key]);
                        }

                        foreach($allTags as $allTag)
                        {
                            if(!empty($allTag) && !in_array($allTag, $oldTags))
                            {
                                $tagModel = new Tag();
                                $tagModel->name = $allTag;
                                $tagModel->article = 1;
                                $tagModel->save();
                            }
                        }
                    }

                    $article->save();

                    if(!empty($file))
                    {
                        if(in_array($file->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/article';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'article_' . str_replace('.', '', microtime(true)) . '.' . strtolower($file->getClientOriginalExtension());

                            $file->move($path, $fileName);

                            Util::cropImage($path . '/' . $fileName, 1540, 900);

                            if(!empty($article->image_src))
                            {
                                $imageSrcParts = explode('/', $article->image_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $article->image_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/article/' . $fileName;
                            $article->save();
                        }
                    }

                    if(!empty($thumbnail))
                    {
                        if(in_array($thumbnail->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/article_thumbnail';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'article_thumbnail_' . str_replace('.', '', microtime(true)) . '.' . strtolower($thumbnail->getClientOriginalExtension());

                            $thumbnail->move($path, $fileName);

                            Util::cropImage($path . '/' . $fileName, 585, 585);

                            if(!empty($article->thumbnail_src))
                            {
                                $imageSrcParts = explode('/', $article->thumbnail_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $article->thumbnail_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/article_thumbnail/' . $fileName;
                            $article->save();
                        }
                    }

                    Db::commit();

                    return redirect('admin/article');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['article' => $article, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['article' => $article, 'errors' => $errors]);
        }

        return view($view, ['article' => $article]);
    }

    public function deleteArticle($id)
    {
        $article = Article::find($id);

        if($article->validateDelete())
        {
            if(!empty($article->image_src))
            {
                $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/article';

                $imageSrcParts = explode('/', $article->image_src);

                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                if(file_exists($oldFilePath) && is_file($oldFilePath))
                    unlink($oldFilePath);
            }

            if(!empty($article->thumbnail_src))
            {
                $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/article_thumbnail';

                $imageSrcParts = explode('/', $article->thumbnail_src);

                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                if(file_exists($oldFilePath) && is_file($oldFilePath))
                    unlink($oldFilePath);
            }

            $article->delete();

            if(!empty($article->tags))
            {
                $tags = explode(';', $article->tags);

                $tagModels = Tag::whereIn('name', $tags)->get();

                foreach($tagModels as $tagModel)
                {
                    $tagModel->article -= 1;
                    $tagModel->save();
                }
            }

            return redirect('admin/article');
        }

        return redirect('admin/article/edit/' . $id);
    }

    public function listTag(Request $request)
    {
        $input = $request->all();

        $builder = Tag::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $tags = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.blogs.list_tag', [
            'tags' => $tags,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createTag(Request $request)
    {
        $tag = new Tag();

        return $this->saveTag($request, $tag, 'admin.blogs.create_tag');
    }

    public function editTag(Request $request, $id)
    {
        $tag = Tag::find($id);

        return $this->saveTag($request, $tag, 'admin.blogs.edit_tag');
    }

    protected function saveTag($request, $tag, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('tag');

            $tag->name = isset($input['name']) ? trim($input['name']) : '';

            $errors = $tag->validate();

            if(count($errors) == 0)
            {
                if(empty($tag->id))
                    $tag->article = 0;

                $tag->save();
                return redirect('admin/tag');
            }

            return view($view, ['tag' => $tag, 'errors' => $errors]);
        }

        return view($view, ['tag' => $tag]);
    }

    public function getAutoCompleteTagData(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $term = trim($input['term']);

                $tags = Tag::where('name', 'like', '%' . $term . '%')->limit(10)->get();

                $data = array();

                foreach($tags as $tag)
                    $data[] = $tag->name;

                echo json_encode($data);
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function listWidget(Request $request)
    {
        $input = $request->all();

        $builder = Widget::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(isset($input['filter']['status']) && $input['filter']['status'] !== '')
                $builder->where('status', $input['filter']['status']);

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $widgets = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.blogs.list_widget', [
            'widgets' => $widgets,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createWidget(Request $request)
    {
        $widget = new Widget();
        $widget->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveWidget($request, $widget, 'admin.blogs.create_widget', 'create');
    }

    public function editWidget(Request $request, $id)
    {
        $widget = Widget::find($id);

        return $this->saveWidget($request, $widget, 'admin.blogs.edit_widget', 'edit');
    }

    protected function saveWidget($request, $widget, $view, $action)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('widget');

            if($action == 'create')
            {
                $widget->name = isset($input['name']) ? trim($input['name']) : '';
                $widget->type = isset($input['type']) ? trim($input['type']) : '';
            }

            $widget->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $widget->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $widget->save();

                    if($action == 'edit')
                    {
                        $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/widget';

                        if(!file_exists($path))
                            mkdir($path, 0755, true);

                        switch($widget->type)
                        {
                            case Util::TYPE_WIDGET_SLIDER_VALUE:

                                $files = $request->file('image');

                                $widgetDetails = array();
                                if(!empty($widget->detail))
                                    $widgetDetails = json_decode($widget->detail, true);

                                if(isset($input['detail']['id']))
                                {
                                    foreach($widgetDetails as $keyDetail => $widgetDetail)
                                    {
                                        $updateDetail = false;

                                        foreach($input['detail']['id'] as $keyInput => $inputDetailId)
                                        {
                                            if($widgetDetail['id'] == $inputDetailId)
                                            {
                                                $widgetDetails[$keyDetail]['caption'] = isset($input['detail']['caption'][$keyInput]) ? $input['detail']['caption'][$keyInput]: '';
                                                $widgetDetails[$keyDetail]['url'] = isset($input['detail']['url'][$keyInput]) ? $input['detail']['url'][$keyInput]: '';
                                                $widgetDetails[$keyDetail]['position'] = $keyInput + 1;

                                                if(isset($files[$keyInput]))
                                                {
                                                    if(in_array($files[$keyInput]->getClientOriginalExtension(), Util::getValidImageExt()))
                                                    {
                                                        $fileName = 'widget_' . str_replace('.', '', microtime(true)) . '.' . strtolower($files[$keyInput]->getClientOriginalExtension());

                                                        $files[$keyInput]->move($path, $fileName);

                                                        switch($widget->name)
                                                        {
                                                            case Util::WIDGET_NAME_HOME_SLIDER:

                                                                Util::cropImage($path . '/' . $fileName, Util::WIDGET_HOME_SLIDER_IMAGE_MAX_WIDTH, Util::WIDGET_HOME_SLIDER_IMAGE_MAX_HEIGHT);

                                                                break;
                                                        }

                                                        $imageSrcParts = explode('/', $widgetDetail['image_src']);

                                                        $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                                        if(file_exists($oldFilePath) && is_file($oldFilePath))
                                                            unlink($oldFilePath);

                                                        $widgetDetails[$keyDetail]['image_src'] = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/widget/' . $fileName;
                                                    }
                                                }

                                                $updateDetail = true;
                                                unset($input['detail']['id'][$keyInput]);
                                                break;
                                            }
                                        }

                                        if($updateDetail == false)
                                        {
                                            $imageSrcParts = explode('/', $widgetDetail['image_src']);

                                            $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                            if(file_exists($oldFilePath) && is_file($oldFilePath))
                                                unlink($oldFilePath);

                                            unset($widgetDetails[$keyDetail]);
                                        }
                                    }

                                    foreach($input['detail']['id'] as $keyInput => $inputDetailId)
                                    {
                                        if(isset($files[$keyInput]))
                                        {
                                            if(in_array($files[$keyInput]->getClientOriginalExtension(), Util::getValidImageExt()))
                                            {
                                                $fileName = 'widget_' . str_replace('.', '', microtime(true)) . '.' . strtolower($files[$keyInput]->getClientOriginalExtension());

                                                $files[$keyInput]->move($path, $fileName);

                                                switch($widget->name)
                                                {
                                                    case Util::WIDGET_NAME_HOME_SLIDER:

                                                        Util::cropImage($path . '/' . $fileName, Util::WIDGET_HOME_SLIDER_IMAGE_MAX_WIDTH, Util::WIDGET_HOME_SLIDER_IMAGE_MAX_HEIGHT);

                                                        break;
                                                }

                                                $newImageSrc = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/widget/' . $fileName;

                                                $widgetDetails[] = [
                                                    'id' => $inputDetailId,
                                                    'image_src' => $newImageSrc,
                                                    'caption' => isset($input['detail']['caption'][$keyInput]) ? $input['detail']['caption'][$keyInput]: '',
                                                    'url' => isset($input['detail']['url'][$keyInput]) ? $input['detail']['url'][$keyInput]: '',
                                                    'position' => $keyInput + 1,
                                                ];
                                            }
                                        }
                                    }

                                    $widget->detail = json_encode($widgetDetails);
                                }
                                else
                                {
                                    foreach($widgetDetails as $widgetDetail)
                                    {
                                        $imageSrcParts = explode('/', $widgetDetail['image_src']);

                                        $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                        if(file_exists($oldFilePath) && is_file($oldFilePath))
                                            unlink($oldFilePath);
                                    }

                                    $widget->detail = null;
                                }

                                break;
                        }

                        $widget->save();
                    }

                    Db::commit();

                    return redirect('admin/widget');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['widget' => $widget, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['widget' => $widget, 'errors' => $errors]);
        }

        return view($view, ['widget' => $widget]);
    }

    public function openElFinder()
    {
        return view('admin.blogs.partials.elFinder');
    }

    public function connectorElFinder()
    {
        $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/article_images';

        if(!file_exists($path))
            mkdir($path, 0755, true);

        $opts = [
            'roots'  => [
                [
                    'driver'        => 'LocalFileSystem',
                    'path'          => $path,
                    'URL'           => 'http://' . request()->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/article_images',
                    'uploadDeny'    => ['all'],
                    'uploadAllow'   => ['image', 'text/plain'],
                    'uploadOrder'   => ['deny', 'allow'],
                    'accessControl' => 'App\Admin\Http\Controllers\BlogController::access',
                ]
            ]
        ];

        $connector = new Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

    public static function access($attr, $path, $data, $volume)
    {
        return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
            ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
            :  null;                                    // else elFinder decide it itself
    }
}