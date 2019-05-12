<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


class HF
{

    public static function updateModel($updateable, $model, $request) {
        foreach($updateable as $u) {
            if($request->json($u)) $model->{$u} = $request->json($u);
        }
        $model->save();
    }

}