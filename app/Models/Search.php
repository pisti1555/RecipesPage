<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public static function listRecipes(Request $request)
    {
        $orderby = $request->query('orderby', 'created_at');
        $direction = $request->query('direction','asc');

        if (!$request->query('orderby')) {
            return Recipe::latest()->get();
        }

        if ($orderby == 'rating') {
            $recipes = Recipe::all()->sortBy(function($recipe) {
                return $recipe->getRating();
            });
    
            if ($direction == 'desc') {
                $recipes = $recipes->reverse();
            }
    
            return $recipes->values();
        }

        return Recipe::orderBy($orderby, $direction)->get();
    }

}
