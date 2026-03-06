/* define functions here */

function calculateTotal(quantity, price) {
    return quantity * price;
}

function outputCartRow(file, title, quantity, price, total) {
    return `
        <tr>
            <td><img src="images/${file}"></td>
            <td>${title}</td>
            <td>${quantity}</td>
            <td>$${price.toFixed(2)}</td>
            <td>$${total.toFixed(2)}</td>
        </tr>
    `;
}