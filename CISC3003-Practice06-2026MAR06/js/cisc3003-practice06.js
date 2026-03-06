/* add loop and other code here ... in this simple exercise we are not
   going to concern ourselves with minimizing globals, etc */
/* cisc3003-practice06.js - 主要執行檔 */

function calculateSubtotal() {
    let subtotal = 0;
    for (let i = 0; i < filenames.length; i++) {
        subtotal += calculateTotal(quantities[i], prices[i]);
    }
    return subtotal;
}

function calculateTax(subtotal) {
    return subtotal * 0.1;
}

function calculateShipping(subtotal) {
    return subtotal > 1000 ? 0 : 40;
}

function calculateGrandTotal(subtotal, tax, shipping) {
    return subtotal + tax + shipping;
}

function outputCarts() {
    const tbody = document.querySelector('tbody');
    
    const subtotal = calculateSubtotal();
    const tax = calculateTax(subtotal);
    const shipping = calculateShipping(subtotal);
    const grandTotal = calculateGrandTotal(subtotal, tax, shipping);
    
    let html = '';
    
    for (let i = 0; i < filenames.length; i++) {
        const total = calculateTotal(quantities[i], prices[i]);
        html += outputCartRow(filenames[i], titles[i], quantities[i], prices[i], total);
    }
    
    html += `
        <tr class="totals">
            <td colspan="4">Subtotal</td>
            <td>$${subtotal.toFixed(2)}</td>
        </tr>
        <tr class="totals">
            <td colspan="4">Tax</td>
            <td>$${tax.toFixed(2)}</td>
        </tr>
        <tr class="totals">
            <td colspan="4">Shipping</td>
            <td>$${shipping.toFixed(2)}</td>
        </tr>
        <tr class="totals focus">
            <td colspan="4">Grand Total</td>
            <td>$${grandTotal.toFixed(2)}</td>
        </tr>
    `;
    
    tbody.innerHTML = html;
}

window.onload = function() {
    outputCarts();
};