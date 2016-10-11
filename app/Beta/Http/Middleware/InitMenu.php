<?php

namespace App\Beta\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Libraries\Util;
use App\Models\Menu;

class InitMenu
{
    public function handle(Request $request, Closure $next)
    {
        $nextWeekMenus = Menu::where('status', Util::STATUS_MENU_NEXT_WEEK_VALUE)->get();
        foreach($nextWeekMenus as $nextWeekMenu)
        {
            $timeToChange = strtotime($nextWeekMenu->week) - (Util::TIMESTAMP_ONE_DAY * 7);

            if(strtotime('now') >= $timeToChange)
            {
                $nextWeekMenu->status = Util::STATUS_MENU_CURRENT_VALUE;
                $nextWeekMenu->week = null;
                $nextWeekMenu->save();
            }
        }

        return $next($request);
    }
}