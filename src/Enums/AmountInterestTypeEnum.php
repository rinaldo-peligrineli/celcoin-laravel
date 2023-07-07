<?php

namespace WeDevBr\Celcoin\Enums;

enum AmountInterestTypeEnum: string
{
    case VALUE_CALENDAR_DAYS = 'VALUE_CALENDAR_DAYS';
    case PERCENTAGE_PER_DAY_CALENDAR_DAYS = 'PERCENTAGE_PER_DAY_CALENDAR_DAYS';
    case PERCENTAGE_PER_MONTH_CALENDAR_DAYS = 'PERCENTAGE_PER_MONTH_CALENDAR_DAYS';
    case PERCENTAGE_PER_YEAR_CALENDAR_DAYS = 'PERCENTAGE_PER_YEAR_CALENDAR_DAYS';
    case VALUE_WORKING_DAYS = 'VALUE_WORKING_DAYS';
    case PERCENTAGE_PER_DAYWORKING_DAYS = 'PERCENTAGE_PER_DAYWORKING_DAYS';
    case PERCENTAGE_PER_MONTH_WORKING_DAYS = 'PERCENTAGE_PER_MONTH_WORKING_DAYS';
    case PERCENTAGE_PER_YEAR_WORKING_DAYS = 'PERCENTAGE_PER_YEAR_WORKING_DAYS';
}