<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    use HasFactory;

    protected $attributes = [
        'gridMap',
        'nodeList'
    ];

    protected $fillable = [
        'gridMap',
        'nodeList'
    ];

    public function initializeNodes()
    {
        $nodeList = collect();
        $arrayX = count($this->gridMap);
        $arrayY = count($this->gridMap[0]);

        $id = 0;

        for ($row = 0; $row < $arrayX; $row++) {
            for ($col = 0; $col < $arrayY; $col++) {
                
                $nodeList->push(new Node([
                    'id' => $id,
                    'x' => $row,
                    'y' => $col,
                    'passable' => $this->gridMap[$row][$col]
                ]));

                $id++;
            }
        }

        $this->nodeList = $nodeList;

        foreach ($this->nodeList as $node) {
            $node->findNeighbours($this->nodeList);
        }
    }  
}
