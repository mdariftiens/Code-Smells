# Duplicate Code


## Signs and Symptoms:
Two code fragments look almost identical.

## Reasons for the Problem:

* Multiple programmers are working on different parts of the same program 
* Subtle duplication- when specific parts of code look different but actually perform the same job. This kind of duplication can be hard to find and fix.
* Purposefulduplication- When rushing to meet deadlines and the existing code is "almost right" for the job, novice programmers may not be able to resist the temptation of copying and pasting the relevant code. And in some cases, the programmer is simply too lazy.

## Case and Solution

To refactor our code we can use various strategies. For example, 
1. when we have two equal code blocks within the **same class**, we can simply ***extract the method and invoke the call in both places***. This strategy called **Extract Method**
2. If instead we have two identical methods in **different classes that extend the same class**, we can ***move the method in the parent class and delete it from the other two subclasses***. 
3. If the code is similar but not exactly the same, we must first extract the method with the equal parts and then move it to the parent class. 
4. If we have two methods that do the same thing but with **two different algorithms**, we can choose which ***algorithm is the best and use only it and substitute the algorithm***. This strategy called   **Substitute Algorithm**.
5. If you have duplicate code in classes that are not related, we can think of creating a parent class and move the method, or if the objects cannot be children of the same class, we may decide to keep the method in a single class and invoke it from a related class, or to create a third class and invoke the method of this third class in the other two. 
6. If a large number of conditional expressions are present and perform the same code (differing only in their conditions), merge these operators into a single condition using **Consolidate Conditional Expression** and use **Extract Method** to place the condition in a separate method with an easy-to-understand name.
7. If the same code is performed in all branches of a conditional expression: place the identical code outside of the condition tree by using **Consolidate Duplicate Conditional Fragments**.

###### The strategies can be varied—it’s up to us to understand what is best and choose it
#
#
#### Example ( 2nd stratigy: different classes that extend the same class )
---
#
#
```php
class Person
{ 

} 

class Customer extends Person
{
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2010-12-17"));
    }
 
}
class Vendor extends Person
{
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2010-12-17"));
    }
}
```
To delete this duplication we can move the getAge() method in the parent class.
```php
class Person
{ 
    public function getAge()
    {
        return date('Y') - date('Y', strtotime("2000-11-25"));
    }
} 

class Customer extends Person
{

}
class Vendor extends Person
{

}
```