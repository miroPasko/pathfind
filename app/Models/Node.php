<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

    protected $attributes = [
        'id',
        'x',
        'y',
        'g' => 0.0,
        'h' => 0.0,
        'f' => PHP_FLOAT_MAX,
        'passable',
        'parent',
        'neighbours'
    ];

    protected $fillable = [
        'id',
        'x',
        'y',
        'passable'
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
        'g' => 'float',
        'h' => 'float',
        'f' => 'float'
    ];

    public function findNeighbours($nodeList) {
        $neighbours = [];
        
        $north = $nodeList->filter(function ($node) {
            return ($node->x == $this->x - 1 AND $node->y == $this->y);
        });
        if($north->count()){
            $neighbours['north'] = $north->first()->id;
        }

        $south = $nodeList->filter(function ($node) {
            return ($node->x == $this->x + 1 AND $node->y == $this->y);
        });
        if($south->count()){
            $neighbours['south'] = $south->first()->id;
        }

        $west = $nodeList->filter(function ($node) {
            return ($node->x == $this->x AND $node->y == $this->y - 1);
        });
        if($west->count()){
            $neighbours['west'] = $west->first()->id;
        }

        $east = $nodeList->filter(function ($node) {
            return ($node->x == $this->x AND $node->y == $this->y + 1);
        });
        if($east->count()){
            $neighbours['east'] = $east->first()->id;
        }

        $this->neighbours = $neighbours;
    }
}
