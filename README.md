Refactoring: 
===========
Refactoring is a disciplined technique for restructuring an existing body of code, altering its internal structure without changing its external behavior.

Bad code smells:
===
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
