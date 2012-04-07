# SLOP
`S`tandard `L`ibrary `O`bjects for `PHP`.

`SLOP` is just a little pet project to play with some of the lesser used Object Oriented features of PHP.
`SLOP`'s goal is to create object wrappers for many of the functions of PHP's standard library to give
the overall use of the language a more OO-feel.  Very heavily inspired by Python, and alittle bit of
JavaScript, too.  Throws built in Exception types, rather than triggering errors.

Again, the point of this project is mostly just an experiment, but these classes are still totally
usable, if you wish to drop them into your project. Goals for version 1 include these 3 classes:

* `Listing` - An ordered set - essentially a non-associative Array, inspired by `List` in Python and an `Array` in JavaScript.
* `Ditionary` - A set of key/value pairs, with values being any object or type, and keys beings strings.
* `Regex` - A Regular Expression object, based on the `RegExp` object in JavaScript.
