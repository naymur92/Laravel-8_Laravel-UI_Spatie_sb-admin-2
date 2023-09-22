<?php

use App\Models\DropdownValue;

// get dropdown text-value by value and type
function getDropdownTextValue($type, $value)
{
  return DropdownValue::where('type', $type)->where('value', $value)->select('text_value')->pluck('text_value')->first() ?? '';
}
