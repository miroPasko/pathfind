<?php

namespace App\Classes;

use App\Models\Grid;
use Illuminate\Support\Facades\Storage;

class Pathfinder
{
    function pathfind($gridMap, $start, $end){

        $grid = new Grid([
            'gridMap' => $gridMap,
            'nodeList' => []
        ]);

        $grid->initializeNodes();

        $openNodes = collect();
        $closedNodes = collect();

        $startNode = $grid->nodeList->filter(function ($node) use ($start) {
            return ($node->x == $start[0] AND $node->y == $start[1]);
        })->first();

        $endNode = $grid->nodeList->filter(function ($node) use ($end) {
            return ($node->x == $end[0] AND $node->y == $end[1]);
        })->first();

        if(!$startNode && ! $endNode){
            return null;
        }

        $openNodes->push($startNode);

        while($openNodes->count()){
            $openNodes = $openNodes->sortBy('f');
            $currentNode = $openNodes->shift();
            
            $neighbours = $grid->nodeList->whereIn('id', $currentNode->neighbours);

            foreach($neighbours as $neighbour){
                if($neighbour->x == $endNode->x && $neighbour->y == $endNode->y){
                    $neighbour->parent = $currentNode;
                    return $this->retracePath($neighbour);
                }

                if(!$neighbour->passable) {
                    $closedNodes->push($neighbour);
                    continue;
                }

                $newG = $currentNode->g + 1;
                $newH = $this->manhattanDistHeur($neighbour, $endNode);
                $newF = $newG + $newH;

                $closedMatch = $closedNodes->filter(function ($node) use ($neighbour) {
                    return ($node->x == $neighbour->x AND $node->y == $neighbour->y);
                });
                if($closedMatch->count()){
                    continue;
                }

                $openMatch = $grid->nodeList->filter(function ($node) use ($neighbour, $newF) {
                    return ($node->x == $neighbour->x AND $node->y == $neighbour->y AND $node->f > $newF);
                });
                if($openMatch->count()) {
                    $neighbour->g = $newG;
                    $neighbour->h = $newH;
                    $neighbour->f = $newF;

                    $neighbour->parent = $currentNode;

                    $openNodes->push($neighbour);
                }

            }
            $closedNodes->push($currentNode);
        }

        return "Path not found";
    }

    function manhattanDistHeur($node, $endNode) {
        return abs($node->x - $endNode->x) + 
               abs($node->y - $endNode->y);
    }

    function retracePath($node) {

        $currentNode = $node;
        $path = [];
 
        while($currentNode->parent){
            $path[] = $currentNode->id;

            $currentNode = $currentNode->parent;
        }

        return count($path);
    }

    public static function getMapData($fileName) {
        $mapData = [];

        if(Storage::disk('local')->exists($fileName)){
            $mapFile = Storage::disk('local')->get($fileName);

            $gridMap = [[]];
            $startPoint = [];
            $endPoint = [];
            $xCount = 0;
            $yCount = 0;

            foreach(mb_str_split($mapFile) as $char){
                if(!ctype_space($char)) {
                    if($char == ".") {
                        $gridMap[$xCount][$yCount] = 1;
                    } else if ($char == "#") {
                        $gridMap[$xCount][$yCount] = 0;
                    } else if ($char == "P") {
                        $gridMap[$xCount][$yCount] = 1;
                        $startPoint = [$xCount,$yCount];
                    } else if ($char == "Q") {
                        $gridMap[$xCount][$yCount] = 1;
                        $endPoint = [$xCount,$yCount];
                    }

                    $yCount++;
                }

                if(strstr($char, PHP_EOL)){
                    $xCount++;
                    $yCount = 0;
                }
            }

            $mapData['gridMap'] = $gridMap;
            $mapData['startPoint'] = $startPoint;
            $mapData['endPoint'] = $endPoint;
        }

        return $mapData;
    }
}
