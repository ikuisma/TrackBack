<?php

  class PlanController extends BaseController{

    public static function sandbox(){
        // Testaa koodiasi täällä
        $musicians = Musician::all();
        $qsma = Musician::find(1);
        $tags = Tag::all();
        Kint::dump($musicians);
        Kint::dump($qsma);
        Kint::dump($tags);
    }

  }
