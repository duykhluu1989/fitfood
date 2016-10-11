<?php

namespace App\Admin\Http\Controllers;

use Excel;
use DB;
use Illuminate\Http\Request;
use App\Models\MealPack;
use App\Libraries\Util;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Resource;
use App\Models\Recipe;
use App\Models\RecipeResource;
use App\Models\Menu;
use App\Models\MenuRecipe;

class MenuController extends Controller
{
    public function listMealPack()
    {
        $builder = MealPack::select('*');

        $builder->orderBy('id', 'DESC');

        $mealPacks = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.menus.list_meal_pack', ['mealPacks' => $mealPacks]);
    }

    public function createMealPack(Request $request)
    {
        $mealPack = new MealPack();
        $mealPack->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveMealPack($request, $mealPack, 'admin.menus.create_meal_pack');
    }

    public function editMealPack(Request $request, $id)
    {
        $mealPack = MealPack::find($id);

        return $this->saveMealPack($request, $mealPack, 'admin.menus.edit_meal_pack');
    }

    protected function saveMealPack($request, $mealPack, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('mealPack');

            $file = $request->file('image');

            $mealPack->name = isset($input['name']) ? trim($input['name']) : '';
            $mealPack->name_en = isset($input['name_en']) ? trim($input['name_en']) : '';
            $mealPack->price = isset($input['price']) ? trim(str_replace('.', '', $input['price'])) : '';
            $mealPack->description = isset($input['description']) ? trim($input['description']) : '';
            $mealPack->description_en = isset($input['description_en']) ? trim($input['description_en']) : '';
            $mealPack->mini_description = isset($input['mini_description']) ? trim($input['mini_description']) : '';
            $mealPack->mini_description_en = isset($input['mini_description_en']) ? trim($input['mini_description_en']) : '';
            $mealPack->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->breakfast = isset($input['breakfast']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->lunch = isset($input['lunch']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->dinner = isset($input['dinner']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->fruit = isset($input['fruit']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->veggies = isset($input['veggies']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->vegetarian = isset($input['vegetarian']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->juice = isset($input['juice']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $mealPack->type = (!isset($input['type']) || is_array(Util::getMealPackType(trim($input['type']))) ? Util::MEAL_PACK_TYPE_PACK_VALUE : trim($input['type']));

            $double = array();
            if(isset($input['breakfast_double']))
                $double['breakfast'] = 1;
            if(isset($input['lunch_double']))
                $double['lunch'] = 1;
            if(isset($input['dinner_double']))
                $double['dinner'] = 1;

            $mealPack->double = json_encode($double);

            $errors = $mealPack->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $mealPack->save();

                    if(!empty($file))
                    {
                        if(in_array($file->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/meal_pack';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'meal_pack_' . str_replace('.', '', microtime(true)) . '.' . strtolower($file->getClientOriginalExtension());

                            $file->move($path, $fileName);

                            Util::cropImage($path . '/' . $fileName, 1250, 1003);

                            if(!empty($mealPack->image_src))
                            {
                                $imageSrcParts = explode('/', $mealPack->image_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $mealPack->image_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/meal_pack/' . $fileName;
                            $mealPack->save();
                        }
                    }

                    Db::commit();

                    return redirect('mealPack');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['mealPack' => $mealPack, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['mealPack' => $mealPack, 'errors' => $errors]);
        }

        return view($view, ['mealPack' => $mealPack]);
    }

    public function listCategory()
    {
        $builder = Category::select('*');

        $builder->orderBy('id', 'DESC');

        $categories = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.menus.list_category', ['categories' => $categories]);
    }

    public function createCategory(Request $request)
    {
        $category = new Category();
        $category->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveCategory($request, $category, 'admin.menus.create_category');
    }

    public function editCategory(Request $request, $id)
    {
        $category = Category::find($id);

        return $this->saveCategory($request, $category, 'admin.menus.edit_category');
    }

    protected function saveCategory($request, $category, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('category');

            $category->name = isset($input['name']) ? trim($input['name']) : '';
            $category->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $category->validate();

            if(count($errors) == 0)
            {
                $category->save();
                return redirect('category');
            }

            return view($view, ['category' => $category, 'errors' => $errors]);
        }

        return view($view, ['category' => $category]);
    }

    public function listUnit()
    {
        $builder = Unit::select('*');

        $builder->orderBy('id', 'DESC');

        $units = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.menus.list_unit', ['units' => $units]);
    }

    public function createUnit(Request $request)
    {
        $unit = new Unit();
        $unit->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveUnit($request, $unit, 'admin.menus.create_unit');
    }

    public function editUnit(Request $request, $id)
    {
        $unit = Unit::find($id);

        return $this->saveUnit($request, $unit, 'admin.menus.edit_unit');
    }

    protected function saveUnit($request, $unit, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('unit');

            $unit->name = isset($input['name']) ? trim($input['name']) : '';
            $unit->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $unit->validate();

            if(count($errors) == 0)
            {
                $unit->save();
                return redirect('unit');
            }

            return view($view, ['unit' => $unit, 'errors' => $errors]);
        }

        return view($view, ['unit' => $unit]);
    }

    public function listResource(Request $request)
    {
        $input = $request->all();

        $builder = Resource::select('*');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['category']))
                $builder->where('category_id', $input['filter']['category']);

            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['name_en']))
                $builder->where('name_en', 'like', '%' . $input['filter']['name_en'] . '%');

            if(!empty($input['filter']['code']))
                $builder->where('code', 'like', '%' . $input['filter']['code'] . '%');

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('id', 'DESC');

        $resources = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.menus.list_resource', [
            'resources' => $resources,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createResource(Request $request)
    {
        $resource = new Resource();
        $resource->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveResource($request, $resource, 'admin.menus.create_resource');
    }

    public function editResource(Request $request, $id)
    {
        $resource = Resource::find($id);

        return $this->saveResource($request, $resource, 'admin.menus.edit_resource');
    }

    protected function saveResource($request, $resource, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('resource');

            $resource->name = isset($input['name']) ? trim($input['name']) : '';
            $resource->name_en = isset($input['name_en']) ? trim($input['name_en']) : '';
            $resource->code = isset($input['code']) ? trim($input['code']) : '';
            $resource->category_id = isset($input['category_id']) ? trim($input['category_id']) : '';
            $resource->unit_id = isset($input['unit_id']) ? trim($input['unit_id']) : '';
            $resource->price = isset($input['price']) ? trim(str_replace('.', '', $input['price'])) : '';
            $resource->quantity = isset($input['quantity']) ? trim(str_replace('.', '', $input['quantity'])) : '';
            $resource->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;

            $errors = $resource->validate();

            if(count($errors) == 0)
            {
                $resource->save();
                return redirect('resource');
            }

            return view($view, ['resource' => $resource, 'errors' => $errors]);
        }

        return view($view, ['resource' => $resource]);
    }

    public function listRecipe(Request $request)
    {
        list($recipes, $filter, $queryString) = $this->getListRecipe($request, 'list');

        return view('admin.menus.list_recipe', [
            'recipes' => $recipes,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createRecipe(Request $request)
    {
        $recipe = new Recipe();
        $recipe->status = Util::STATUS_ACTIVE_VALUE;

        return $this->saveRecipe($request, $recipe, 'admin.menus.create_recipe');
    }

    public function editRecipe(Request $request, $id)
    {
        $recipe = Recipe::with('recipeResources.resource.unit')->find($id);

        return $this->saveRecipe($request, $recipe, 'admin.menus.edit_recipe');
    }

    protected function saveRecipe($request, $recipe, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('recipe');

            $recipe->name = isset($input['name']) ? trim($input['name']) : '';
            $recipe->name_en = isset($input['name_en']) ? trim($input['name_en']) : '';
            $recipe->status = isset($input['status']) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
            $recipe->price = 0;

            $tempRecipeResourceModels = array();

            if(isset($input['resource']['name']))
            {
                $tempResources = array();

                foreach($input['resource']['name'] as $key => $name)
                {
                    $name = trim($name);

                    if(!isset($tempResources['name']) || !in_array($name, $tempResources['name']))
                    {
                        $tempResources['name'][$key] = trim($name);
                        $tempResources['quantity'][$key] = trim(str_replace('.', '', $input['resource']['quantity'][$key]));
                    }
                }

                foreach($tempResources['name'] as $key => $name)
                {
                    $tempResourceModel = Resource::where('status', Util::STATUS_ACTIVE_VALUE)->where('name', $name)->first();

                    if(!empty($tempResourceModel))
                    {
                        $tempRecipeResourceModel = new RecipeResource();
                        $tempRecipeResourceModel->resource_id = $tempResourceModel->id;
                        $tempRecipeResourceModel->quantity = $tempResources['quantity'][$key];
                        $tempRecipeResourceModel->price = round($tempResourceModel->price * $tempRecipeResourceModel->quantity / $tempResourceModel->quantity);

                        $tempRecipeResourceModels[] = $tempRecipeResourceModel;
                    }
                }
            }

            $updateRecipeResourceIds = array();

            foreach($tempRecipeResourceModels as $tempRecipeResourceModel)
            {
                $update = false;

                foreach($recipe->recipeResources as $key => $recipeResource)
                {
                    if($recipeResource->resource_id == $tempRecipeResourceModel->resource_id)
                    {
                        $recipe->recipeResources[$key]->quantity = $tempRecipeResourceModel->quantity;
                        $recipe->recipeResources[$key]->price = $tempRecipeResourceModel->price;

                        $updateRecipeResourceIds[] = $recipeResource->id;
                        $update = true;
                        break;
                    }
                }

                if($update == false)
                    $recipe->recipeResources[] = $tempRecipeResourceModel;
            }

            $deleteRecipeResourceModels = array();

            $countUpdateRecipeResourceId = count($updateRecipeResourceIds);

            foreach($recipe->recipeResources as $key => $recipeResource)
            {
                if(!empty($recipeResource->id) && ($countUpdateRecipeResourceId == 0 || !in_array($recipeResource->id, $updateRecipeResourceIds)))
                {
                    $deleteRecipeResourceModels[] = $recipeResource;
                    unset($recipe->recipeResources[$key]);
                }
            }

            foreach($recipe->recipeResources as $recipeResource)
                $recipe->price += $recipeResource->price;

            $errors = $recipe->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $recipe->save();

                    foreach($recipe->recipeResources as $recipeResource)
                    {
                        $recipeResource->recipe_id = $recipe->id;
                        $recipeResource->save();
                    }

                    foreach($deleteRecipeResourceModels as $recipeResource)
                        $recipeResource->delete();

                    Db::commit();

                    return redirect('recipe');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['recipe' => $recipe, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['recipe' => $recipe, 'errors' => $errors]);
        }

        return view($view, ['recipe' => $recipe]);
    }

    public function getAutoCompleteResourceData(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $term = trim($input['term']);
                $lang = trim($input['lang']);

                if($lang == 'en')
                    $resources = Resource::with('unit')->where('status', Util::STATUS_ACTIVE_VALUE)->where('name_en', 'like', '%' . $term . '%')->get();
                else
                    $resources = Resource::with('unit')->where('status', Util::STATUS_ACTIVE_VALUE)->where('name', 'like', '%' . $term . '%')->get();

                $data = array();

                foreach($resources as $resource)
                {
                    $data[] = [
                        'name' => $resource->name,
                        'name_en' => $resource->name_en,
                        'price' => Util::formatMoney($resource->price),
                        'quantity' => Util::formatMoney($resource->quantity),
                        'unit' => $resource->unit->name,
                    ];
                }

                echo json_encode($data);
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function exportRecipe(Request $request)
    {
        list($recipes, $filter, $queryString) = $this->getListRecipe($request, 'export');

        $exportData[] = [
            'Dish name (VI)',
            'Dish name (EN)',
            'Resource name (VI)',
            'Resource name (EN)',
            'Quantity',
            'Unit',
            'CPU',
            'Cost',
            'Calories',
            'Carb',
            'Fat',
            'Protein',
        ];

        foreach($recipes as $recipe)
        {
            $exportData[] = [
                $recipe->name,
                $recipe->name_en,
                $recipe->recipeResources[0]->resource->name,
                $recipe->recipeResources[0]->resource->name_en,
                $recipe->recipeResources[0]->quantity,
                $recipe->recipeResources[0]->resource->unit->name,
                round($recipe->recipeResources[0]->resource->price / $recipe->recipeResources[0]->resource->quantity),
                $recipe->recipeResources[0]->price,
                '',
                '',
                '',
                '',
            ];

            $countResource = count($recipe->recipeResources);

            for($i = 1;$i < $countResource;$i ++)
            {
                $exportData[] = [
                    '',
                    '',
                    $recipe->recipeResources[$i]->resource->name,
                    $recipe->recipeResources[$i]->resource->name_en,
                    $recipe->recipeResources[$i]->quantity,
                    $recipe->recipeResources[$i]->resource->unit->name,
                    round($recipe->recipeResources[$i]->resource->price / $recipe->recipeResources[0]->resource->quantity),
                    $recipe->recipeResources[$i]->price,
                    '',
                    '',
                    '',
                    '',
                ];
            }

            $exportData[] = [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $recipe->price,
                '',
                '',
                '',
                '',
            ];
        }

        Excel::create('export-recipe-' . date('Y-m-d'), function($excel) use($exportData) {

            $excel->sheet('sheet1', function($sheet) use($exportData) {

                $sheet->fromArray($exportData, null, 'A1', true, false);

            });

        })->export('xlsx');
    }

    protected function getListRecipe($request, $action)
    {
        $input = $request->all();

        $builder = Recipe::select('ff_recipe.*')->with('recipeResources.resource.unit');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('ff_recipe.name', 'like', '%' . $input['filter']['name'] . '%');

            if(!empty($input['filter']['name_en']))
                $builder->where('ff_recipe.name_en', 'like', '%' . $input['filter']['name_en'] . '%');

            if(!empty($input['filter']['resource']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_recipe_resource` on') === false)
                    $builder->join('ff_recipe_resource', 'ff_recipe.id', '=', 'ff_recipe_resource.recipe_id');
                if(strpos($sql, 'inner join `ff_resource` on') === false)
                    $builder->join('ff_resource', 'ff_recipe_resource.resource_id', '=', 'ff_resource.id');
                $builder->where('ff_resource.name', 'like', '%' . $input['filter']['resource'] . '%');
            }

            if(!empty($input['filter']['resource_en']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_recipe_resource` on') === false)
                    $builder->join('ff_recipe_resource', 'ff_recipe.id', '=', 'ff_recipe_resource.recipe_id');
                if(strpos($sql, 'inner join `ff_resource` on') === false)
                    $builder->join('ff_resource', 'ff_recipe_resource.resource_id', '=', 'ff_resource.id');
                $builder->where('ff_resource.name_en', 'like', '%' . $input['filter']['resource_en'] . '%');
            }

            $filter = $input['filter'];
            $queryString = '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
        {
            $filter = null;
            $queryString = null;
        }

        $builder->orderBy('ff_recipe.id', 'DESC');

        $builder->groupBy('ff_recipe.id');

        if($action == 'list')
            $recipes = $builder->paginate(Util::GRID_PER_PAGE);
        else
            $recipes = $builder->get();

        return [$recipes, $filter, $queryString];
    }

    public function listMenu(Request $request)
    {
        $input = $request->all();

        $builder = Menu::select('*')->with('menuRecipes.breakfastRecipe', 'menuRecipes.lunchRecipe', 'menuRecipes.dinnerRecipe');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['name']))
                $builder->where('name', 'like', '%' . $input['filter']['name'] . '%');

            if(isset($input['filter']['type']) && $input['filter']['type'] !== '')
                $builder->where('type', $input['filter']['type']);

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

        $menus = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.menus.list_menu', [
            'menus' => $menus,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function createMenu(Request $request)
    {
        $menu = new Menu();
        $menu->type = Util::TYPE_MENU_NORMAL_VALUE;
        $menu->status = Util::STATUS_MENU_CURRENT_VALUE;

        return $this->saveMenu($request, $menu, 'admin.menus.create_menu');
    }

    public function editMenu(Request $request, $id)
    {
        $menu = Menu::with('menuRecipes')->find($id);

        return $this->saveMenu($request, $menu, 'admin.menus.edit_menu');
    }

    protected function saveMenu($request, $menu, $view)
    {
        if($request->isMethod('post'))
        {
            $input = $request->input('menu');

            $file = $request->file('image');

            $menu->name = isset($input['name']) ? trim($input['name']) : '';
            $menu->status = isset($input['status']) ? trim($input['status']) : $menu->status;
            $menu->type = isset($input['type']) ? trim($input['type']) : $menu->type;

            if($menu->status == Util::STATUS_MENU_NEXT_WEEK_VALUE)
                $menu->week = date('Y-m-d', strtotime('+ ' . (15 - date('N')) . ' days'));

            $tempMenuRecipeModels = array();

            if(isset($input['recipe']['name']))
            {
                foreach($input['recipe']['name'] as $dayOfWeek => $mealOfDay)
                {
                    $tempMenuRecipeModel = null;

                    if(is_array($mealOfDay) && count($mealOfDay) > 0)
                    {
                        foreach($mealOfDay as $meal => $name)
                        {
                            $name = trim($name);

                            $tempRecipeModel = Recipe::where('status', Util::STATUS_ACTIVE_VALUE)->where('name', $name)->first();

                            if(!empty($tempRecipeModel))
                            {
                                if(empty($tempMenuRecipeModel))
                                {
                                    $tempMenuRecipeModel = new MenuRecipe();
                                    $tempMenuRecipeModel->day_of_week = $dayOfWeek;
                                    $tempMenuRecipeModel->status = isset($input['recipe']['status'][$dayOfWeek]) ? Util::STATUS_ACTIVE_VALUE : Util::STATUS_INACTIVE_VALUE;
                                }

                                if($meal == Util::MEAL_BREAKFAST_LABEL)
                                    $tempMenuRecipeModel->breakfast_id = $tempRecipeModel->id;
                                else if($meal == Util::MEAL_LUNCH_LABEL)
                                    $tempMenuRecipeModel->lunch_id = $tempRecipeModel->id;
                                else if($meal == Util::MEAL_DINNER_LABEL)
                                    $tempMenuRecipeModel->dinner_id = $tempRecipeModel->id;
                            }
                        }
                    }

                    if(!empty($tempMenuRecipeModel))
                        $tempMenuRecipeModels[] = $tempMenuRecipeModel;
                }
            }

            foreach($tempMenuRecipeModels as $tempMenuRecipeModel)
            {
                $update = false;

                foreach($menu->menuRecipes as $key => $menuRecipe)
                {
                    if($menuRecipe->day_of_week == $tempMenuRecipeModel->day_of_week)
                    {
                        $menu->menuRecipes[$key]->breakfast_id = $tempMenuRecipeModel->breakfast_id;
                        $menu->menuRecipes[$key]->lunch_id = $tempMenuRecipeModel->lunch_id;
                        $menu->menuRecipes[$key]->dinner_id = $tempMenuRecipeModel->dinner_id;
                        $menu->menuRecipes[$key]->status = $tempMenuRecipeModel->status;

                        $update = true;
                        break;
                    }
                }

                if($update == false)
                    $menu->menuRecipes[] = $tempMenuRecipeModel;
            }

            $errors = $menu->validate();

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $menu->save();

                    foreach($menu->menuRecipes as $menuRecipe)
                    {
                        $menuRecipe->menu_id = $menu->id;
                        $menuRecipe->save();
                    }

                    if(!empty($file))
                    {
                        if(in_array($file->getClientOriginalExtension(), Util::getValidImageExt()))
                        {
                            $path = base_path() . Util::UPLOAD_IMAGE_DIR . '/menu';

                            if(!file_exists($path))
                                mkdir($path, 0755, true);

                            $fileName = 'menu_' . str_replace('.', '', microtime(true)) . '.' . strtolower($file->getClientOriginalExtension());

                            $file->move($path, $fileName);

                            Util::cropImage($path . '/' . $fileName, 1381, 795);

                            if(!empty($menu->image_src))
                            {
                                $imageSrcParts = explode('/', $menu->image_src);

                                $oldFilePath = $path . '/' . $imageSrcParts[count($imageSrcParts) - 1];

                                if(file_exists($oldFilePath) && is_file($oldFilePath))
                                    unlink($oldFilePath);
                            }

                            $menu->image_src = 'http://' . $request->getHttpHost() . Util::UPLOAD_IMAGE_DIR . '/menu/' . $fileName;
                            $menu->save();
                        }
                    }

                    Db::commit();

                    return redirect('menu');
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    return view($view, ['menu' => $menu, 'errors' => [$e->getMessage()]]);
                }
            }

            return view($view, ['menu' => $menu, 'errors' => $errors]);
        }

        return view($view, ['menu' => $menu]);
    }

    public function getAutoCompleteRecipeData(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $term = trim($input['term']);

                $recipes = Recipe::where('status', Util::STATUS_ACTIVE_VALUE)->where(function($query) use($term) {
                    $query->where('name', 'like', '%' . $term . '%')->orWhere('name_en', 'like', '%' . $term . '%');
                })->get();

                $data = array();

                foreach($recipes as $recipe)
                {
                    $data[] = [
                        'name' => $recipe->name,
                        'name_en' => $recipe->name_en,
                    ];
                }

                echo json_encode($data);
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }
}