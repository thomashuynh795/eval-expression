<?php

function eval_expression($inFix) {
  $postFix = shuting_yard_algorithm($inFix);
  $result = postfix_evalutation($postFix);
  return($result);
}

// returns the postfix of the infix expression
function shuting_yard_algorithm($inFix) {
  $postFix = [];
  $operatorStack = [];
  $inFix = convert_infix($inFix);
  foreach($inFix as $value) {
    process_token($value, $postFix, $operatorStack);
  }
  while(!empty($operatorStack)) {
    array_push($postFix, array_pop($operatorStack));
  }
  return($postFix);
}

// returns an array of the expression with separated operands and operators from the string infix expression
function convert_infix($inFix) {
  $result = [];
  $inFix = trim($inFix);
  $inFix = str_split($inFix);
  $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "."];
  for($i = 0; $i < count($inFix); $i++) {
    if(in_array($inFix[$i], $array)) {
      $string = "";
      if(isset($inFix[$i+1])) {
        while(in_array($inFix[$i], $array)) {
          $string .= $inFix[$i];
          $i++;
        }
        $i--;
      }
      else $string .= $inFix[$i];
      array_push($result, $string);
    }
    else {
      array_push($result, $inFix[$i]);
    }
  }
  return($result);
}

// evaluates each element of the infix array
function process_token($value, &$postFix, &$operatorStack) {
  if(is_numeric($value)) {
    array_push($postFix, $value);
  }
  else if(is_operator($value)) {
    if(end($operatorStack) != "(") {
      while(get_order($value) <= get_order(end($operatorStack))) {
        $operator = array_pop($operatorStack);
        array_push($postFix, $operator);
      }
    }
    array_push($operatorStack, $value);
  }
  else if($value == "(") {
    array_push($operatorStack, $value);
  }
  else if($value == ")") {
    while(end($operatorStack) != "(") {
      $operator = array_pop($operatorStack);
      array_push($postFix, $operator);
    }
    array_pop($operatorStack);
  }
  return(1);
}

// checks if the element is an operator
function is_operator($string) {
  $operators = ["+", "-", "*", "/", "%"];
  if(in_array($string, $operators)) {
    return(true);
  }
  else return(false);
}

// returns the order priority of the symbol
function get_order($operator) {
  $checker = ["+", "-", "*", "/", "%", "(", ")"];
  if(in_array($operator, $checker)) {
    $array = [
      ["("],
      ["+", "-"],
      ["*", "/", "%"],
      [")"]
    ];
    foreach($array as $key => $value) {
      if(in_array($operator, $value)) {
        return($key);
      }
    }
  }
  else {
    return(-1);
  }
}

// prints infix array
function echo_infix($inFix) {
  echo "infix = ";
  foreach($inFix as $value) {
    echo $value;
  }
  echo PHP_EOL;
  return(1);
}

// prints postfix array
function echo_postfix($postFix) {
  echo "infix = ";
  $string = "";
  foreach($postFix as $value) {
    $string .= $value." ";
  }
  $string = substr($string, 0, -1);
  echo $string.PHP_EOL;
  return(1);
}

// evaluates the postfix expression
function postfix_evalutation($expression) {
  $stack = [];
  foreach($expression as $value) {
    if(is_numeric($value)) {
      array_push($stack, $value);
    }
    else if(is_operator($value)) {
      switch($value) {
        case "+":
          $right = array_pop($stack);
          $left = array_pop($stack);
          array_push($stack, addition($left, $right));
          break;
        case "-":
          $right = array_pop($stack);
          $left = array_pop($stack);
          array_push($stack, substraction($left, $right));
          break;
        case "*":
          $right = array_pop($stack);
          $left = array_pop($stack);
          array_push($stack, multiplication($left, $right));
          break;
        case "/":
          $right = array_pop($stack);
          $left = array_pop($stack);
          array_push($stack, division($left, $right));
          break;
        case "%":
          $right = array_pop($stack);
          $left = array_pop($stack);
          array_push($stack, modulo($left, $right));
          break;
      }
    }
  }
  return(floatval($stack[0]));
}

function addition($left, $right) {
  return($left + $right);
}

function substraction($left, $right) {
  return($left - $right);
}

function multiplication($left, $right) {
  return($left*$right);
}

function division($left, $right) {
  return($left/$right);
}

function modulo($left, $right) {
  return($left%$right);
}

