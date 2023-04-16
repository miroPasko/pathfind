<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class PathfinderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_pathfinder(): void
    {
        $files = Storage::disk('local')->files("mapTests");

        foreach($files as $file){
            $number = str_replace(["mapTests/map", ".txt"], "", $file);
            
            $successText = "Length of the path = " . $number;
            if ($number == "0"){
                $successText = "Path not found";
            }

            $this->artisan("app:pathfinder ".$file)
            ->expectsOutput($successText)
            ->assertExitCode(0);
        }
    }
}
