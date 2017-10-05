Refactoring: 
===========

Refactoring is a disciplined technique for restructuring an existing body of code, altering its internal structure without changing its external behavior.

Bad code smells:
===

Code smell, also known as bad smell, in computer programming code, refers to any symptom in the source code of a program that possibly indicates a deeper problem. According to Martin Fowler, "a code smell is a surface indication that usually corresponds to a deeper problem in the system".

Code smell - Wikipedia https://en.wikipedia.org/wiki/Code_smell

Duplicate Code
---

**Signs and Symptoms:**
Two code fragments look almost identical.

**Reasons for the Problem:**

* Multiple programmers are working on different parts of the same program 
* Subtle duplication- when specific parts of code look different but actually perform the same job. This kind of duplication can be hard to find and fix.
* Purposefulduplication- When rushing to meet deadlines and the existing code is "almost right" for the job, novice programmers may not be able to resist the temptation of copying and pasting the relevant code. And in some cases, the programmer is simply too lazy.

**Treatment**

* If the same code is found in two or more methods in the same class: use Extract Method and place calls for the new method in both places.
* If the same code is found in two subclasses of the same level:Use Extract Method for both classes, followed by Pull Up Field for the fields used in the method that you are pulling up.
* If the duplicate code is inside a constructor, use Pull Up Constructor Body.
* If the duplicate code is similar but not completely identical, use Form Template Method.
* If two methods do the same thing but use different algorithms, select the best algorithm and apply Substitute Algorithm.
* If duplicate code is found in two different classes:
* If the classes are not part of a hierarchy, use Extract Superclass in order to create a single superclass for these classes that maintains all the previous functionality.
* If it is difficult or impossible to create a superclass, use Extract Class in one class and use the new component in the other.
* If a large number of conditional expressions are present and perform the same code (differing only in their conditions), merge these operators into a single condition using Consolidate Conditional Expression and use Extract Method to place the condition in a separate method with an easy-to-understand name.
* If the same code is performed in all branches of a conditional expression: place the identical code outside of the condition tree by using Consolidate Duplicate Conditional Fragments.

**Example**
```
class Person
{ 

} 

class Customer extends Person
{
 public function getAge()
 {
   return date('Y') - date('Y', $this->getBirthday());
 }
 
}
class Vendor extends Person
{

 public function getAge()
 {
   return date('Y') - date('Y', $this->getBirthday());
 }
}
```
To delete this duplication we can move the getAge() method in the parent class.
```
class Person
{ 
 public function getAge()
 {
   return date('Y') - date('Y', $this->getBirthday());
 }
} 
```

Long Method: 
---

**Signs and Symptoms:**
Generally, any method longer than ten lines should make you start asking questions.

**Reasons for the Problem:**
Since it is easier to write code than to read it, this "smell" remains unnoticed until the method turns into an ugly, oversized beast.

Mentally, it is often harder to create a new method than to add to an existing one: "But it's just two lines, there's no use in creating a whole method just for that..." Which means that another line is added and then yet another, giving birth to a tangle of spaghetti code.

In the following example we have the Order class with a method that is too long.
```
class Order
{
 ...
 public function calculate()
 {
 $details = $this->getOrderDetails();

 foreach($details as $detail)
 {
 if (!$detail->hasVat())
 {
 $vat = $this->getCustomer()->getVat();
 }
 else
 {
 $vat = $detail->getVat();
 }
 $price = $detail->getAmount() * $detail->getPrice();
 $total += $price + ($price/100 * $vat->getValue());
 }

 if ($this->hasDiscount())
 {
 $total = $total – ($total/100 * $this->getDiscount());
 }
 elseif($this->getCustomer()->hasDiscountForMaxAmount()
 && $total >= $this->getCustomer()->getMaxAmountForDiscount())
 {
 $total = $total – ($total/100 * $this->getCustomer()->getDiscountForMaxAmount())
 }
 return $total;
 }
}
```
First, we can simplify this method extracting two methods—one to calculate detail total price and
another to calculate the right order discount.
```
class Order
{
 private function calculateDetailsPrice()
 {
 foreach($this->getOrderDetails() as $detail)
 {
 if (!$detail->hasVat())
 {
 $vat = $this->getCustomer()->getVat();
 }
 else
 {
 $vat = $detail->getVat();
 }
 $price = $detail->getAmount() * $detail->getPrice();
 $total += $price + ($price/100 * $vat->getValue());
 }
 return $total;
 }

 private function applyDiscount($total)
 {
 if ($this->hasDiscount())
 {
 $total = $total – ($total/100 * $this->getDiscount());
 }
 elseif($this->getCustomer()->hasDiscountForMaxAmount() &&
 $total >= $this->getCustomer()->getMaxAmountForDiscount())
 {
 $total = $total – ($total/100 * $this->getCustomer()->getDiscountForMaxAmount())
 }
 return $total;
 }
 public function calculate()
 {
 return $this->applyDiscount($this->calculateDetailsPrice());
 }
} 
```

Large Class
Primitive Obsession
Long Parameter List
Data Clumps
Switch Statements
Temporary Field
Refused Bequest
Alternative Classes with Different Interfaces
Divergent Change
Shotgun Surgery
Parallel Inheritance Hierarchies
Comments
Duplicate Code
Lazy Class
Data Class
Dead Code
Speculative Generality
Feature Envy
Inappropriate Intimacy
Message Chains
Middle Man
Incomplete Library Class
