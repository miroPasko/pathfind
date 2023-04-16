<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\Pathfinder as PathEngine;

class Pathfinder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pathfinder {file=map.txt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a pathfinding simulation based on 2d grid model with 4-directional movement';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('file');

        $pathEngine = new PathEngine();

        $mapData = PathEngine::getMapData($fileName);

        $pathLength = $pathEngine->pathfind($mapData['gridMap'], $mapData['startPoint'], $mapData['endPoint']);
    
        if(is_numeric($pathLength)){
            $this->info("Length of the path = ".$pathLength);
        } else {
            $this->error($pathLength);
        }
    }
}
