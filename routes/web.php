<?php

Route::get("/", IndexController::class);
Route::post("/guardar", IndexController::class . "@guardar");
