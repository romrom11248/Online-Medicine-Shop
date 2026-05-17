<?php
function isempty($data){
    if(trim($data)==""){
        return true;
    }
    else{
        return false;
    }
}

    function validpassword($password){
        if(strlen($password)>=8){
            return true;
        }
        else{
            return false;
        }
    }   
?>