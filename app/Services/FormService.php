<?php namespace App\Services;

use App\Models\Forms;

class FormService {

    function getForm($page){

        $formdata = [];
        if($page->forms()->count())
            $formdata = $page->forms()->first()->form;

        if($formdata)
            $formdata->load('questions.type', 'questions.choices');

        return $formdata;
    }
}