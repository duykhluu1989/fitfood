<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Util;
use App\Models\Menu;

class UpdateMenu extends Command
{
    protected $signature = 'UpdateMenu';

    protected $description = 'Update next week menu';

    public function handle()
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
    }
}
