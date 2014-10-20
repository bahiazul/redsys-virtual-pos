<?php
/**
 * :attribute => el nombre del campo
 * :params => parametros pasados a la regla ( p.ej: :params(0) = 10 de max_length(10) )
 */
return [
    'required'      => 'El campo :attribute es obligatorio',
    'integer'       => 'El campo :attribute ha de ser un número entero',
    'float'         => 'El campo :attribute ha de ser un número de coma flotante',
    'numeric'       => 'El campo :attribute ha de ser numérico',
    'email'         => ':attribute no es un email válido',
    'alpha'         => 'El campo :attribute ha de contener exclusivamente letras',
    'alpha_numeric' => 'El campo :attribute ha de contener exclusivamente caracteres alfanuméricos',
    'ip'            => ':attribute ha de contener una dirección IP válida',
    'url'           => ':attribute ha de contener una dirección URL válida',
    'max_length'    => ':attribute ha de tener un máximo de :params(0) caracteres de longitud',
    'min_length'    => ':attribute ha de tener un mínimo de :params(0) caracteres de longitud',
    'exact_length'  => 'El campo :attribute ha de tener una longitud de :params(0) caracteres exactamente',
    'equals'        => 'El campo :attribute ha de ser igual a :params(0)',
    'in_array'      => 'El valor del campo :attribute no está entre valores disponibles',
    'match_regex'   => 'El valor del campo :attribute no se corresponde con el patrón establecido',
];
