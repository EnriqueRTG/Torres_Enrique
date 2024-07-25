<?php

// Mostrar errores en los formalarios despues de las validaciones

function display_form_errors($validation, $field){
    if ($validation->hasError($field)) {
        return $validation->getError($field);
    }
}