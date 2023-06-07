<?php
use Illuminate\Support\Facades\Auth;

function getDateNowParse()
{
    return date_parse(now());
}

function getUserId()
{
    return Auth::user()->id;
}
