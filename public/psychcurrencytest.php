<?php
 
  echo "Enter the amount in US dollars: $";
 
  $money = read_stdin();
 
  echo "What currency do you want to convert to? (E)uros, (P)esos, (B)ritish Pounds: ";
 
  $currency = strtoupper(read_stdin());
  $converted = convert($money, $currency);
 
  echo "$$money is equivalent to $converted euros\n";
 
  function convert($money, $currency)
  {
    $conversion_dict = array(
      "E" => 0.73,
      "P" => 13,
      "B" => 0.60
    );
 
    ## Old-school debugging
    # echo $conversion_dict; --> this won't work at all
    # var_dump($conversion_dict);
    # print_r($conversion_dict)
 
require('/home/vagrant/.composer/vendor/autoload.php');
\Psy\Shell::debug(get_defined_vars());
 
    $converted_value = $money * $conversion_dict[$currency];
    return $converted_value;
  }
 
  // our function to read from the command line
  function read_stdin()
  {
    $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
    $input = fgets($fr,128);        // read a maximum of 128 characters
    $input = rtrim($input);         // trim any trailing spaces.
    fclose ($fr);                   // close the file handle
    return $input;                  // return the text entered
  }
?>