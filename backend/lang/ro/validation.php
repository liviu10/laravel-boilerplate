<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Campul :attribute trebuie acceptat.',
    'accepted_if' => 'Campul :attribute trebuie acceptat cand :other este :value.',
    'active_url' => 'Campul :attribute trebuie sa fie o adresa URL valida.',
    'after' => 'Campul :attribute trebuie sa fie o data dupa :date.',
    'after_or_equal' => 'Campul :attribute trebuie sa fie o data ulterioara sau egala cu :date.',
    'alpha' => 'Campul :attribute trebuie sa contina numai litere.',
    'alpha_dash' => 'Campul :attribute trebuie sa contina numai litere, cifre, liniute si liniute de subliniere.',
    'alpha_num' => 'Campul :attribute trebuie sa contina numai litere si cifre.',
    'array' => 'Campul :attribute trebuie sa fie o matrice.',
    'ascii' => 'Campul :attribute trebuie sa contina doar caractere si simboluri alfanumerice pe un singur octet.',
    'before' => 'Campul :attribute trebuie sa fie o data inainte de :date.',
    'before_or_equal' => 'Campul :attribute trebuie sa fie o data anterioara sau egala cu :date.',
    'between' => [
        'array' => 'Campul :attribute trebuie sa aiba intre elemente :min si :max.',
        'file' => 'Campul :attribute trebuie sa fie intre :min si :max kilobytes.',
        'numeric' => 'Campul :attribute trebuie sa fie intre :min si :max.',
        'string' => 'Campul :attribute trebuie sa aiba intre caractere :min si :max.',
    ],
    'boolean' => 'Campul :attribute trebuie sa fie adevarat sau fals.',
    'confirmed' => 'Confirmarea campului :attribute nu se potriveste.',
    'current_password' => 'Parola este incorecta.',
    'date' => 'Campul :attribute trebuie sa fie o data valida.',
    'date_equals' => 'Campul :attribute trebuie sa fie o data egala cu :date.',
    'date_format' => 'Campul :attribute trebuie sa se potriveasca cu formatul :format.',
    'decimal' => 'Campul :attribute trebuie sa aiba :decimal zecimale.',
    'declined' => 'Campul :attribute trebuie sa fie refuzat.',
    'declined_if' => 'Campul :attribute trebuie sa fie refuzat atunci cand :other este :value.',
    'different' => 'Campul :attribute si :other trebuie sa fie diferite.',
    'digits' => 'Campul :attribute trebuie sa aiba :digits cifre.',
    'digits_between' => 'Campul :attribute trebuie sa fie intre :min si :max cifre.',
    'dimensions' => 'Campul :attribute are dimensiuni de imagine nevalide.',
    'distinct' => 'Campul :attribute are o valoare duplicata.',
    'doesnt_end_with' => 'Campul :attribute nu trebuie sa se termine cu una dintre urmatoarele: :values.',
    'doesnt_start_with' => 'Campul :attribute nu trebuie sa inceapa cu una dintre urmatoarele: :values.',
    'email' => 'Campul :attribute trebuie sa fie o adresa de email valida.',
    'ends_with' => 'Campul :attribute trebuie sa se termine cu una dintre urmatoarele: :values.',
    'enum' => 'Optiunea selectata :attribute este invalida.',
    'exists' => 'Optiunea selectata :attribute este invalida.',
    'file' => 'Campul :attribute trebuie sa fie un fisier.',
    'filled' => 'Campul :attribute trebuie sa aiba o valoare.',
    'gt' => [
        'array' => 'Campul :attribute trebuie sa aiba mai mult de :value elemente.',
        'file' => 'Campul :attribute trebuie sa fie mai mare de :value kilobiti.',
        'numeric' => 'Campul :attribute trebuie sa fie mai mare de :value.',
        'string' => 'Campul :attribute trebuie sa aiba mai mult de :value caractere.',
        ],
    'gte' => [
        'array' => 'Campul :attribute trebuie sa aiba :value elemente sau mai multe.',
        'file' => 'Campul :attribute trebuie sa fie mai mare sau egal cu :value kilobiti.',
        'numeric' => 'Campul :attribute trebuie sa fie mai mare sau egal cu :value.',
        'string' => 'Campul :attribute trebuie sa aiba :value caractere sau mai multe.',
    ],
    'image' => 'Campul :attribute trebuie sa fie o imagine.',
    'in' => ':attribute selectat este invalid.',
    'in_array' => 'Campul :attribute trebuie sa existe in :other.',
    'integer' => 'Campul :attribute trebuie sa fie un numar intreg.',
    'ip' => 'Campul :attribute trebuie sa fie o adresa IP valida.',
    'ipv4' => 'Campul :attribute trebuie sa fie o adresa IPv4 valida.',
    'ipv6' => 'Campul :attribute trebuie sa fie o adresa IPv6 valida.',
    'json' => 'Campul :attribute trebuie sa fie un sir JSON valid.',
    'lowercase' => 'Campul :attribute trebuie sa fie scris cu litere mici.',
    'lt' => [
        'array' => 'Campul :attribute trebuie sa aiba mai putin de :value elemente.',
        'file' => 'Campul :attribute trebuie sa fie mai mic de :value kiloocteti.',
        'numeric' => 'Campul :attribute trebuie sa fie mai mic de :value.',
        'string' => 'Campul :attribute trebuie sa fie mai mic de :value caractere.',
    ],
    'lte' => [
        'array' => 'Campul :attribute nu trebuie sa aiba mai mult de :value elemente.',
        'file' => 'Campul :attribute trebuie sa fie mai mic sau egal cu :value kiloocteti.',
        'numeric' => 'Campul :attribute trebuie sa fie mai mic sau egal cu :value.',
        'string' => 'Campul :attribute trebuie sa fie mai mic sau egal cu :value caractere.',
    ],
    'mac_address' => 'Campul :attribute trebuie sa fie o adresa MAC valida.',
    'max' => [
        'array' => 'Campul :attribute nu trebuie sa aiba mai mult de :max elemente.',
        'file' => 'Campul :attribute nu trebuie sa fie mai mare de :max kiloocteti.',
        'numeric' => 'Campul :attribute nu trebuie sa fie mai mare de :max.',
        'string' => 'Campul :attribute nu trebuie sa fie mai mare de :max caractere.',
    ],
    'max_digits' => 'Campul :attribute nu trebuie sa aiba mai mult de :max cifre.',
    'mimes' => 'Campul :attribute trebuie sa fie un fisier de tipul: :values.',
    'mimetypes' => 'Campul :attribute trebuie sa fie un fisier de tipul: :values.',
    'min' => [
        'array' => 'Campul :attribute trebuie sa aiba cel putin :min elemente.',
        'file' => 'Campul :attribute trebuie sa aiba cel putin :min kilobyti.',
        'numeric' => 'Campul :attribute trebuie sa fie cel putin :min.',
        'string' => 'Campul :attribute trebuie sa aiba cel putin :min caractere.',
    ],
    'min_digits' => 'Campul :attribute trebuie sa aiba cel putin :min cifre.',
    'missing' => 'Campul :attribute trebuie sa lipseasca.',
    'missing_if' => 'Campul :attribute trebuie sa lipseasca cand :other este :value.',
    'missing_unless' => 'Campul :attribute trebuie sa lipseasca cu exceptia cazului in care :other este :value.',
    'missing_with' => 'Campul :attribute trebuie sa lipseasca cand :values este prezent.',
    'missing_with_all' => 'Campul :attribute trebuie sa lipseasca cand :values sunt prezente.',
    'multiple_of' => 'Campul :attribute trebuie sa fie un multiplu de :value.',
    'not_in' => ':attribute selectat este invalid.',
    'not_regex' => 'Formatul campului :attribute este invalid.',
    'numeric' => 'Campul :attribute trebuie sa fie un numar.',
    'password' => [
        'letters' => 'Campul :attribute trebuie sa contina cel putin o litera.',
        'mixed' => 'Campul :attribute trebuie sa contina cel putin o litera majuscula si una minuscula.',
        'numbers' => 'Campul :attribute trebuie sa contina cel putin un numar.',
        'symbols' => 'Campul :attribute trebuie sa contina cel putin un simbol.',
        'uncompromised' => ':attribute dat a fost compromis. Va rugam sa alegeti un :attribute diferit.',
    ],
    'present' => 'Campul :attribute trebuie sa fie prezent.',
    'prohibited' => 'Campul :attribute este interzis.',
    'prohibited_if' => 'Campul :attribute este interzis cand :other este :value.',
    'prohibited_unless' => 'Campul :attribute este interzis, cu exceptia cazului in care :other este in :values.',
    'prohibits' => 'Campul :attribute interzice :other sa fie prezent.',
    'regex' => 'Formatul campului :attribute este invalid.',
    'required' => 'Campul :attribute este obligatoriu.',
    'required_array_keys' => 'Campul :attribute trebuie sa contina intrari pentru: :values.',
    'required_if' => 'Campul :attribute este obligatoriu cand :other este :value.',
    'required_if_accepted' => 'Campul :attribute este obligatoriu cand :other este acceptat.',
    'required_unless' => 'Campul :attribute este obligatoriu cu exceptia cazului in care :other este in :values.',
    'required_with' => 'Campul :attribute este obligatoriu cand :values este prezent.',
    'required_with_all' => 'Campul :attribute este obligatoriu cand :values sunt prezente.',
    'required_without' => 'Campul :attribute este obligatoriu cand :values nu este prezent.',
    'required_without_all' => 'Campul :attribute este obligatoriu cand niciunul dintre :values nu este prezent.',
    'same' => 'Campul :attribute trebuie sa se potriveasca cu :other.',
    'size' => [
        'array' => 'Campul :attribute trebuie sa contina :size elemente.',
        'file' => 'Campul :attribute trebuie sa fie de :size kilobyti.',
        'numeric' => 'Campul :attribute trebuie sa fie :size.',
        'string' => 'Campul :attribute trebuie sa contina :size caractere.',
    ],
    'starts_with' => 'Campul :attribute trebuie sa inceapa cu una dintre urmatoarele: :values.',
    'string' => 'Campul :attribute trebuie sa fie un sir de caractere.',
    'timezone' => 'Campul :attribute trebuie sa fie un fus orar valid.',
    'unique' => ':attribute a fost deja luat.',
    'uploaded' => 'incarcarea campului :attribute a esuat.',
    'uppercase' => 'Campul :attribute trebuie sa fie scris cu litere majuscule.',
    'url' => 'Campul :attribute trebuie sa fie un URL valid.',
    'ulid' => 'Campul :attribute trebuie sa fie un ULID valid.',
    'uuid' => 'Campul :attribute trebuie sa fie un UUID valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
