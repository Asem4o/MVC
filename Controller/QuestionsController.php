<?php

namespace Controller;

class QuestionsController
{
    public  function ask(){
        echo 'this is ask function';
    }
    public  function answer($id){
        echo "this is from users with id $id";
    }

}