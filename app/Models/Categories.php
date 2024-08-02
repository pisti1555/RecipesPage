<?php

namespace App\Models;

enum Categories: string
{
        case Maincourse = "Main course";
        case Breakfast = "Breakfast";
        case Dessert = "Dessert";
        case Soup = "Soup";
        case Drink = "Drink";
        case Snack = "Snack";
        case Salad = "Salad";
}
