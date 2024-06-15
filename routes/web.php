<?php

use Illuminate\Support\Facades\Route;




// whatsapp grubuna link atıldı o yüzden kalmak zorunda
Route::get('/new-routes/{id}', function ($id) {
    return redirect("/routes/" . $id);
});


Route::get('/output', function () {
    return Storage::response("python/distance.png");
});
