// anonymous function access variable in outer scope through closure technique
// we also demo how to create an anonymous function and run it instantly
var func = (function () {
    var counter = 0;
    return function () {
        counter++;
        console.log(counter);
    };
})();
func();
func();

// another closure example
// it's amazing!!!
function create() {
    var counter = 0;
    return {
        increment: function () {
            counter++;
        },
        print: function () {
            console.log(counter);
        }
    };
}
var c = create();
c.increment();
c.print(); // 1

// function is also an object, so we can pass function as param to another function
function f1(func) {
    func("hello anonymous function");
}

function f2(txt) {
    console.log(txt);
}

f1(f2);

// add a public property to Person class
var Person = function (name, height) {
    this.name = name;
    this.height = height;
};

var tom = new Person("Tom", 180);
Person.prototype.func = function () {
    console.log("add a public method for class");
};
tom.func();

// private variable: name, price
// private method: set
// privileged method: init
function Product() {
    var name = "";
    var price = -1;

    function set(n, p) {
        if ((n != "") && (p > 0)) {
            name = n;
            price = p;
        } else {
            console.log("init error");
        }
    }

    this.init = function (n, p) {
        // undefined variable
        // console.log(this.name);

        // privileged method can access private variable
        // console.log(name);
        set(n, p);
    };
}

var apple = new Product();
apple.init("apple", 100);

//variable scope demo
// a globally-scoped variable
var a = 1;

// global scope
function one() {
    alert(a);
}

// local scope
function two(a) {
    alert(a);
}

// local scope again
function three() {
    var a = 3;
    alert(a);
}

// Intermediate: no such thing as block scope in javascript
function four() {
    if (true) {
        var a = 4;
    }

    alert(a); // alerts '4', not the global value of '1'
}

// Intermediate: object properties
function Five() {
    this.a = 5;
}

// Advanced: closure
var six = (function () {
    var foo = 6;

    return function () {
        // javascript "closure" means I have access to foo in here,
        // because it is defined in the function in which I was defined.
        alert(foo);
    }
})();

// Advanced: prototype-based scope resolution
function Seven() {
    this.a = 7;
}

// [object].prototype.property loses to [object].property in the scope chain
Seven.prototype.a = -1; // won't get reached, because 'a' is set in the constructor above.
Seven.prototype.b = 8; // Will get reached, even though 'b' is NOT set in the constructor.

// These will print 1-8
one();
two(2);
three();
four();
alert(new Five().a);
six();
alert(new Seven().a);
alert(new Seven().b);

// When calling a function, it is not required that you pass a fixed number of parameters.
// Excess parameters are ignored. Missing parameters are given the value undefined.
function sum() { // Take any number of parameters and return the sum
    var total = 0;
    for (var i = 0; i < arguments.length; ++i) {
        total += arguments[i];
    }
    return total;
}
console.log(sum(1, 2, 3, 4, 5));

// regular expression
var str = "$123";
var pattern = /^\$[\d]+/;
console.log(str.match(pattern));

var pattern = /\d{2}\/\d{2}\/\d{4}/; // match XX/XX/XXXX date format
var pattern = /\b[\w\.-]+@[\w\.-]+\.\w{2,3}\b/; // match email format
var cartoonCrying = /boo(hoo+)+/i; // Part of a regular expression can be grouped together with parentheses.
console.log("Then, he exclaimed 'Boohoooohoohooo'".search(cartoonCrying));
var holyCow = /(sacred|holy) (cow|bovine|bull|taurus)/i; // 
console.log(holyCow.test("Sacred bovine!"));
"Borobudur".replace(/[ou]/g, "a");
var names = "Picasso, Pablo\nGauguin, Paul\nVan Gogh, Vincent";
console.log(names.replace(/([\w ]+), ([\w ]+)/g, "$2 $1"));

// higher order function
function reduce(func, result, arr) {
    arr.forEach(function (element, index) {
        result = func(result, element);
    });

    return result;
}

function count(test, arr) {
    return reduce(function (total, element) {
        return total + ((test(element) ? 1 : 0));
    }, 0, arr);
}

function equals(x) {
    return function (element) {
        return x === element;
    };
}

console.log(count(equals(0), [1, 2, 3, 4, 0, 0, 5, 6]));

// partial application
function map(func, array) {
    var result = [];
    array.forEach(function (element) {
        result.push(func(element));
    });
    return result;
}

function asArray(quasiArray, start) {
    var result = [];
    for (var i = (start || 0); i < quasiArray.length; i++)
        result.push(quasiArray[i]);
    return result;
}

function partial(func) {
    var fixedArgs = asArray(arguments, 1);
    return function () {
        return func.apply(null, fixedArgs.concat(asArray(arguments)));
    };
}

var op = {
    "+": function (a, b) {
        return a + b;
    },
    "==": function (a, b) {
        return a == b;
    },
    "===": function (a, b) {
        return a === b;
    },
    "!": function (a) {
        return !a;
    }
    /* and so on */
};

function square(x) {
    return x * x;
}

console.log(map(partial(op["==="], 0), [1, 2, 3, 0, 4, 0, 0, 5, 6, 0]));
console.log(map(partial(map, square), [[10, 20], [12, 16]]));

// javascript prototype
Function.prototype.method = function (name, func) {
    this.prototype[name] = func;
};

function obj() {}
console.log(obj);
obj.method("test", function () {
    console.log(123);
});
var abc = new obj();
abc.test();

console.log(Function.prototype);
console.log(Object.prototype);

Object.prototype.method = function (name, func) {
    this[name] = func;
};
var fruit = {};
console.log(fruit);
fruit.method("test", function () {
    console.log(456);
});
fruit.test();