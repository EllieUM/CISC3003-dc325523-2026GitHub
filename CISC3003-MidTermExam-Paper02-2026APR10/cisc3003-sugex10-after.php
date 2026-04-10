<?php

include 'includes/book-utilities.inc.php';

$selectedCustomerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

$customers = [];
if (file_exists('data/customers.txt')) {
    $lines = file('data/customers.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $data = explode(';', $line);
        if (count($data) >= 12) {
            $customers[] = [
                'id' => trim($data[0]),
                'first_name' => trim($data[1]),
                'last_name' => trim($data[2]),
                'email' => trim($data[3]),
                'university' => trim($data[4]),
                'address' => trim($data[5]),
                'city' => trim($data[6]),
                'state' => trim($data[7]),
                'country' => trim($data[8]),
                'zip' => trim($data[9]),
                'phone' => trim($data[10]),
                'sales' => trim($data[11])
            ];
        }
    }
}

$orders = [];
if (file_exists('data/orders.txt')) {
    $lines = file('data/orders.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $data = explode(',', $line);
        if (count($data) >= 5) {
            $orders[] = [
                'order_id' => trim($data[0]),
                'customer_id' => trim($data[1]),
                'isbn' => trim($data[2]),
                'title' => trim($data[3]),
                'category' => trim($data[4])
            ];
        }
    }
}

$selectedCustomer = null;
if ($selectedCustomerId) {
    foreach ($customers as $customer) {
        if ($customer['id'] == $selectedCustomerId) {
            $selectedCustomer = $customer;
            break;
        }
    }
}

$customerOrders = [];
if ($selectedCustomerId) {
    foreach ($orders as $order) {
        if ($order['customer_id'] == $selectedCustomerId) {
            $customerOrders[] = $order;
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>DC325523 Lam Cheng Io</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">  -->
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/demo-styles.css">
    
    <script src="https://code.jquery.com/jquery-1.7.2.min.js" ></script>
    <!-- <script src="https://code.getmdl.io/1.1.3/material.min.js"></script> -->
    <script src="js/material.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.sparkline').each(function() {
                var salesData = $(this).text();
                var numbersArray = salesData.split(',').map(Number);
                
                $(this).sparkline(numbersArray, {
                    type: 'bar',
                    barColor: 'darkblue',
                    height: '30px',
                    barWidth: '5px',
                    barSpacing: '2px'
                });
            });
        });
    </script>
  
</head>

<body>
    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
            
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">

            <div class="mdl-grid">

              <!-- mdl-cell + mdl-card -->
              <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card  mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Customers</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <table class="mdl-data-table  mdl-shadow--2dp">
                      <thead>
                        <tr>
                          <th class="mdl-data-table__cell--non-numeric">Name</th>
                          <th class="mdl-data-table__cell--non-numeric">University</th>
                          <th class="mdl-data-table__cell--non-numeric">City</th>
                          <th>Sales</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php foreach ($customers as $customer): ?>
                        <tr>
                          <td class="mdl-data-table__cell--non-numeric">
                            <a href="?customer_id=<?php echo urlencode($customer['id']); ?>">
                              <?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?>
                            </a>
                          </td>
                          <td class="mdl-data-table__cell--non-numeric">
                            <?php echo htmlspecialchars($customer['university']); ?>
                          </td>
                          <td class="mdl-data-table__cell--non-numeric">
                            <?php echo htmlspecialchars($customer['city']); ?>
                          </td>
                          <td>
                            <span class="sparkline"><?php echo $customer['sales']; ?></span>
                          </td>
                        </tr>
                        <?php endforeach; ?>               
                      </tbody>
                    </table>
                </div>
              </div>  <!-- / mdl-cell + mdl-card -->
              
              
            <div class="mdl-grid mdl-cell--5-col">
    

       
                  <!-- mdl-cell + mdl-card -->
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card  mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Customer Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <?php if ($selectedCustomer): ?>
                        <h4><?php echo htmlspecialchars($selectedCustomer['first_name'] . ' ' . $selectedCustomer['last_name']); ?></h4>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($selectedCustomer['email']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($selectedCustomer['address']); ?></p>
                        <p><strong>City:</strong> <?php echo htmlspecialchars($selectedCustomer['city']); ?></p>
                        <p><strong>State:</strong> <?php echo htmlspecialchars($selectedCustomer['state']); ?></p>
                        <p><strong>Country:</strong> <?php echo htmlspecialchars($selectedCustomer['country']); ?></p>
                        <p><strong>Zip/Postal:</strong> <?php echo htmlspecialchars($selectedCustomer['zip']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($selectedCustomer['phone']); ?></p>
                        <?php else: ?>
                        <h4>Customer Name here</h4>
                        <?php endif; ?>                                                                                                                                      
                    </div>    
                  </div>  <!-- / mdl-cell + mdl-card -->   

                  <!-- mdl-cell + mdl-card -->
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card  mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Order Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">       
                               <table class="mdl-data-table  mdl-shadow--2dp">
                                  <thead>
                                    <tr>
                                      <th class="mdl-data-table__cell--non-numeric">Cover</th>
                                      <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                      <th class="mdl-data-table__cell--non-numeric">Title</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  	<?php if ($selectedCustomer): ?>
                                        <?php if (count($customerOrders) > 0): ?>
                                            <?php foreach ($customerOrders as $order): ?>
                                                <tr>
                                                    <td class="mdl-data-table__cell--non-numeric">
                                                        <img src="images/tinysquare/<?php echo htmlspecialchars($order['isbn']); ?>.jpg" 
                                                             alt="Book Cover" 
                                                             style="width: 50px; height: auto;">
                                                    </td>
                                                    <td class="mdl-data-table__cell--non-numeric">
                                                        <?php echo htmlspecialchars($order['isbn']); ?>
                                                    </td>
                                                    <td class="mdl-data-table__cell--non-numeric">
                                                        <?php echo htmlspecialchars($order['title']); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" style="text-align: center;">
                                                    No orders for this customer.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center;">
                                                Select a customer to view.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                  </tbody>
                                </table>
                            	
                        </div>    
                   </div>  <!-- / mdl-cell + mdl-card -->             


               </div>   
           
           
            </div>  <!-- / mdl-grid -->    

        </section>
    </main>    
</div>    <!-- / mdl-layout --> 
          
</body>

<footer>
	<p>CISC3003 Web Programming: DC325523 Lam Cheng Io 2026</p>
</footer>
</html>