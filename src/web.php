<?php

use ProjectZero\LoLDatabase\Models\Summoner;

Route::get('loldatabase', function () {
    echo "LoLDatabase Is A GO!";
    foreach (Summoner::all() as $summoner) {
        echo "<h3>{$summoner->name}</h3>";
    }
});
