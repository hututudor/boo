<?php

function validate(array $data, array $rules): ?array {
  $errors = [];

  foreach ($rules as $field => $fieldRules) {
    foreach ($fieldRules as $rule) {
      switch ($rule) {
        case 'required':
          if(!array_key_exists($field, $data) || empty($data[$field])) {
            $errors[$field] = $field . ' is required';
          }
          break;
        case 'number':
          if(!array_key_exists($field, $data) || !is_numeric($data[$field])) {
            $errors[$field] = $field . ' must be a number';
          }
          break;
        case 'date':
          if(!array_key_exists($field, $data) || !preg_match_all('/^\d{2}\.\d{2}\.\d{4}$/', $data[$field])){
            $errors[$field] = $field . ' must be a valid date';
          }
          break;
      }
    }
  }

  if(count($errors)) {
    return $errors;
  }

  return null;
}
