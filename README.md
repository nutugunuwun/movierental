THE MOVIE RENTAL
================

The sample program is very simple. It is a program to calculate and print a statement of a customer's charges at a video store.
The program is told which movies a customer rented and for how long. It then calculates the charges, which depend on how long
the movie is rented, and identifies the type movie. There are three kinds of movies: regular, children's, and new releases.
In addition to calculating charges, the statement also computes frequent renter points, which vary depending on whether the film is a new release.

Movie is just a simple data class. The rental class represents a customer renting a movie. The customer class represents the customer of the store.
Customer also has the method that produces a statement.


Comments on the Starting Program
--------------------------------
What are your impressions about the design of this program? I would describe it as not well designed and certainly not object oriented.
For a simple program like this, that does not really matter. There's nothing wrong with a quick and dirty simple program. But if this is
a representative fragment of a more complex system, then I have some real problems with this program. That long statement routine in
the Customer class does far too much. Many of the things that it does should really be done by the other classes.

Even so the program works. Is this not just an aesthetic judgment, a dislike of ugly code? It is until we want to change the system.
The compiler doesn't care whether the code is ugly or clean. But when we change the system, there is a human involved, and humans do care.
A poorly designed system is hard to change. Hard because it is hard to figure out where the changes are needed. If it is hard to figure out
what to change, there is a strong chance that the programmer will make a mistake and introduce bugs.

In this case we have a change that the users would like to make. First they want a statement printed in HTML so that the statement can be
Web enabled and fully buzzword compliant. Consider the impact this change would have. As you look at the code you can see that it is impossible to
reuse any of the behavior of the current statement method for an HTML statement. Your only recourse is to write a whole new method that duplicates
much of the behavior of statement. Now, of course, this is not too onerous. You can just copy the statement method and make whatever changes you need.

But what happens when the charging rules change? You have to fix both statement and htmlStatement and ensure the fixes are consistent. The problem with
copying and pasting code comes when you have to change it later. If you are writing a program that you don't expect to change, then cut and paste is fine.
If the program is long lived and likely to change, then cut and paste is a menace.

This brings me to a second change. The users want to make changes to the way they classify movies, but they haven't yet decided on the change they are
going to make. They have a number of changes in mind. These changes will affect both the way renters are charged for movies and the way that frequent renter
points are calculated. As an experienced developer you are sure that whatever scheme users come up with, the only guarantee you're going to have is that they
will change it again within six months.

The statement method is where the changes have to be made to deal with changes in classification and charging rules. If, however, we copy the statement to
an HTML statement, we need to ensure that any changes are completely consistent. Furthermore, as the rules grow in complexity it's going to be harder to
figure out where to make the changes and harder to make them without making a mistake.

You may be tempted to make the fewest possible changes to the program; after all, it works fine. Remember the old engineering adage: "if it ain't broke, don't fix it."
The program may not be broken, but it does hurt. It is making your life more difficult because you find it hard to make the changes your users want.
This is where refactoring comes in.



Refactoring 1: Decomposing and Redistributing the Statement Method
------------------------------------------------------------------
The obvious first target of my attention is the overly long "statement" method. When I look at a long method like that, I am looking to decompose the method
into smaller pieces. Smaller pieces of code tend to make things more manageable. They are easier to work with and move around.

The first phase of the refactoring show how I split up the long method and move the pieces to better classes. My aim is to make it easier to write an HTML
statement method with much less duplication of code.

My first step is to find a logical clump of code and use "Extract Method". An obvious piece here is the switch statement. This looks like it would make
a good chunk to extract into its own method.



Refactoring 2: Renaming
-----------------------
Now that I've broken the original method down into chunks, I can work on them separately. I don't like some of the variable names in $amountFor,
and this is a good place to change them.

Is renaming worth the effort? Absolutely. Good code should communicate what it is doing clearly, and variable names are a key to clear code. Never be
afraid to change the names of things to improve clarity. With good find and replace tools, it is usually not difficult. Strong typing and testing will
highlight anything you miss. Remember: "Any fool can write code that a computer can understand. Good programmers write code that humans can understand."

Code that communicates its purpose is very important. I often refactor just when I'm reading some code. That way as I gain understanding about the program,
I embed that understanding into the code for later so I don't forget what I learned.



Refactoring 3: Moving the Amount Calculation
--------------------------------------------
As I look at "amountFor" method, I can see that it uses information from the rental, but does not use information from the customer.

This immediately raises my suspicions that the method is on the wrong object. In most cases a method should be on the object whose data it uses,
thus the method should be moved to the "rental" class. To do this I use "Move Method". With this you first copy the code over to rental, adjust it to fit in its new home.

In this case fitting into its new home means removing the parameter. I also renamed the method as I did the move.

I can now test to see whether this method works. To do this I replace the body of "Customer::amountFor" to delegate to the new method.



Refactoring 4: Adjust the Reference
-----------------------------------
The next step is to find every reference to the old method and adjust the reference to use the new method.

In this case this step is easy because we just created the method and it is in only one place. In general, however, you need to do a "find" across
all the classes that might be using that method.

The next thing is to remove the old method, "Customer::amountFor", but sometimes I leave the old method to delegate to the new method. This is
useful if it is a public method and I don't want to change the interface of the other class.



Refactoring 5: Replace Temp with Query
--------------------------------------
The next thing that strikes me is that $thisAmount variable is now redundant. It is set to the result of rental charge and not changed afterward.
Thus I can eliminate $thisAmount by using "Replace Temp with Query".

I like to get rid of temporary variables such as this as much as possible. Temps are often a problem in that they cause a lot of parameters to be passed
around when they don't have to be. You can easily lose track of what they are there for. They are particularly insidious in long methods. Of course there is
a performance price to pay; here the charge is now calculated twice. But it is easy to optimize that in the rental class, and you can optimize much more
effectively when the code is properly factored.



Refactoring 6: Extracting Frequent Renter Points
------------------------------------------------
The next step is to do a similar thing for the frequent renter points. The rules vary with the tape, although there is less variation than with charging.
It seems reasonable to put the responsibility on the rental. First we need to use "Extract Method" on the frequent renter points part of the code.

Again we look at the use of locally scoped variables. Again $rental is used and can be passed in as a parameter. The other temp used is $frequentRenterPoints.
In this case $frequentRenterPoints does have a value beforehand. The body of the extracted method doesn't read the value, however, so we don't need to pass it in
as a parameter as long as we use an appending assignment.

With refactoring, small steps are the best; that way less tends to go wrong.



Refactoring 7: Removing Temps
-----------------------------
As I suggested before, temporary variables can be a problem. They are useful only within their own routine, and thus they encourage long, complex routines.
In this case we have two temporary variables, both of which are being used to get a total from the rentals attached to the customer. Both the ASCII and HTML versions
require these totals. I like to use "Replace Temp with Query" to replace $totalAmount and $frequentRentalPoints with query methods. Queries are accessible to any
method in the class and thus encourage a cleaner design without long, complex methods.

I began by replacing $totalAmount with a charge method on customer. This isn't the simplest case of "Replace Temp with Query" $totalAmount was assigned to within the loop,
so I have to copy the loop into the query method.

After that refactoring, I did the same for $frequentRenterPoints.

It is worth stopping to think a bit about the last refactoring. Most refactorings reduce the amount of code, but this one increases it.

The other concern with this refactoring lies in performance. The old code executed the "foreach" loop once, the new code executes it three times. A foreach loop that takes
a long time might impair performance. Many programmers would not do this refactoring simply for this reason. But note the words 'if' and 'might'. Until I profile I cannot
tell how much time is needed for the loop to calculate or whether the loop is called often enough for it to affect the overall performance of the system. Don't worry about
this while refactoring. When you optimize you will have to worry about it, but you will then be in a much better position to do something about it, and you will have more
options to optimize effectively.

These queries are now available for any code written in the customer class. They can easily be added to the interface of the class should other parts of the system need
this information. Without queries like these, other methods have to deal with knowing about the rentals and building the loops. In a complex system, that will lead to much
more code to write and maintain.

You can see the difference immediately with the "htmlStatement". I am now at the point where I take off my refactoring hat and put on my adding function hat. I can write "htmlStatement"
function.

By extracting the calculations I can create the "htmlStatement" method and reuse all of the calculation code that was in the original statement method. I didn't copy and paste,
so if the calculation rules change I have only one place in the code to go to. Any other kind of statement will be really quick and easy to prepare. The refactoring did not
take long. I spent most of the time figuring out what the code did, and I would have had to do that anyway.

Some code is copied from the ASCII version, mainly due to setting up the loop. Further refactoring could clean that up. Extracting methods for header, footer, and detail
line are one route I could take. You can see how to do this in the example for "Form Template Method". But now the users are clamoring again. They are getting ready to
change the classification of the movies in the store. It's still not clear what changes they want to make, but it sounds like new classifications will be introduced, and
the existing ones could well be changed. The charges and frequent renter point allocations for these classifications are to be decided. At the moment, making these kind of
changes is awkward. I have to get into the charge and frequent renter point methods and alter the conditional code to make changes to film classifications. Back on with the refactoring hat.



Refactoring 8: Replacing the Conditional Logic on Price Code with Polymorphism
------------------------------------------------------------------------------
The first part of this problem is that switch statement. It is a bad idea to do a switch based on an attribute of another object. If you must use a switch statement,
it should be on your own data, not on someone else's. This implies that "getCharge" method should move onto "movie" class.

For this to work I had to pass in the length of the rental, which of course is data from the rental. The method effectively uses two pieces of data, the length of the rental and the type of the movie. Why do I prefer to pass the length of rental to the movie rather than the movie type to the rental? It's because the proposed changes are all about adding new types. Type information generally tends to be more volatile. If I change the movie type, I want the least ripple effect, so I prefer to calculate the charge within the movie.

Once I've moved the "getCharge" method, I'll do the same with the frequent renter point calculation. That keeps both things that vary with the type together on the class that has the type.



Refactoring 9: Inheritance
--------------------------
We have several types of movie that have different ways of answering the same question. This sounds like a job for subclasses. We can have three subclasses of movie, each of which can have its own version of charge.

This allows me to replace the switch statement by using polymorphism. Sadly it has one slight flaw—it doesn't work. A movie can change its classification during its lifetime. An object cannot change its class during its lifetime. There is a solution, however, the State pattern [Gang of Four].

By adding the indirection we can do the subclassing from the price code object and change the price whenever we need to.

If you are familiar with the Gang of Four patterns, you may wonder, "Is this a state, or is it a strategy?" Does the price class represent an algorithm for calculating the price (in which case I prefer to call it Pricer or PricingStrategy), or does it represent a state of the movie (Star Trek X is a new release). At this stage the choice of pattern (and name) reflects how you want to think about the structure. At the moment I'm thinking about this as a state of movie. If I later decide a strategy communicates my intention better, I will refactor to do this by changing the names.

To introduce the state pattern I will use three refactorings. First I'll move the type code behavior into the state pattern with "Replace Type Code with State/Strategy". Then I can use "Move Method" to move the switch statement into the price class. Finally I'll use "Replace Conditional with Polymorphism" to eliminate the switch statement.

I begin with "Replace Type Code with State/Strategy". This first step is to use "Self Encapsulate Field" on the type code to ensure that all uses of the type code go through getting
and setting methods. Because most of the code came from other classes, most methods already use the getting method. However, the constructors do access the price code.

I add the new classes. I provide the type code behavior in the price object. I do this with an abstract method on price and concrete methods in the subclasses. I need to change movie's accessors for the price code to use the new class. This means replacing the price code field with a price field, and changing the accessors.

I apply "Move Method" to "getCharge" method. Once it is moved I can start using "Replace Conditional with Polymorphism". I do this by taking one leg of the case statement at a time and creating an overriding method. I start with "RegularPrice" class. This overrides the parent case statement, which I just leave as it is. I compile and test for this case then take the next leg, compile and test. (To make sure I'm executing the subclass code, I like to throw in a deliberate bug and run it to ensure the tests blow up. Not that I'm paranoid or anything.)

When I've done that with all the legs, I declare the "Price::getCharge" method abstract.

I can now do the same procedure with "getFrequentRenterPoints" method. First I move the method over to Price. In this case, however, I don't make the superclass method abstract. Instead I create an overriding method for new releases and leave a defined method (as the default) on the superclass.

Putting in the state pattern was quite an effort. Was it worth it? The gain is that if I change any of price's behavior, add new prices, or add extra price-dependent behavior, the change will be much easier to make. The rest of the application does not know about the use of the state pattern. For the tiny amount of behavior I currently have, it is not a big deal. In a more complex system with a dozen or so price-dependent methods, this would make a big difference. All these changes were small steps. It seems slow to write it this way, but not once did I have to open the debugger, so the process actually flowed quite quickly. It took me much longer to write this section of the book than it did to change the code.

I've now completed the second major refactoring. It is going to be much easier to change the classification structure of movies, and to alter the rules for charging and the frequent renter point system.



Final Thoughts
--------------
This is a simple example, yet I hope it gives you the feeling of what refactoring is like. I've used several refactorings, including "Extract Method", "Move Method", and "Replace Conditional with Polymorphism". All these lead to better-distributed responsibilities and code that is easier to maintain. It does look rather different from procedural style code, and that takes some getting used to. But once you are used to it, it is hard to go back to procedural programs.

The most important lesson from this example is the rhythm of refactoring: test, small change, test, small change, test, small change. It is that rhythm that allows refactoring to move quickly and safely.

*****
