<?php

namespace App\Enums;

enum FormBuilderInputTypes: string
{
    case CHECKBOX = 'checkbox';
    case DATE = 'date';
    case DATETIME_LOCAL = 'datetime-local';
    case EMAIL = 'email';
    case FILE = 'file';
    case MONTH = 'month';
    case NUMBER = 'number';
    case PASSWORD = 'password';
    case RADIO = 'radio';
    case RESET = 'reset';
    case SUBMIT = 'submit';
    case TEL = 'tel';
    case TEXT = 'text';
    case TIME = 'time';
    case WEEK = 'week';
    case SELECT = 'select';
    case TEXTAREA = 'textarea';
}
