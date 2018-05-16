# Poro\Algorithm

Poro researching on algorithms.

## Usage
#### 1.String Searching
First, create searching object with algorithm you want with the argument is the `FullString`, example below describle how to create object with `BruteForce` searching algorithm.
```
$StringSearching = new \Poro\Algorithm\StringSearching\BruteForce('FullString');
```

Then, we can find all the position of a `SearchString` in the `String` with function `run`:
```
$result = $StringSearching->run(SearchString);
```

With `Morris-Pratt`, there is a better version call `Knuth-Morris-Pratt`. By default, the morris-pratt-object will run with the better version. But if you want to use with normal version, you can pass 1/MorrisPratt::MORRIS_PRATT as the second argument of `run` function
