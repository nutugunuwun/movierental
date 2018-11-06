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
*****
