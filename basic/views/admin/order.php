<?php

/* @var $this yii\web\View */

$this->title = 'Orders From Etsy';
?>
<div class="site-index">

  <div class="jumbotron">
    <h2>Order From Etsy</h2>
  </div>

  <div class="body-content">

    <div class="row">
        <div>
          <a href="/order/confirm/<?php echo $order['orderId'] . '?ref=admin'; ?>">edit order</a> <br/><br/>
          <b>ORDER ID : </b> <?php echo $order['orderId']; ?> <br/>
          <b>ORDER NUMBER : </b> <?php echo $order['orderNumber']; ?> <br/>
          <b>ORDER STATUS : </b> <?php echo $order['orderStatus']; ?> <br/>
          <b>CUSTOMER EMAIL: </b> <?php echo $order['customerEmail']; ?> <br/>
          <b>ITEMS : </b> <br/>
        </div>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>SKU</th>
            <th>Name</th>
            <th>Color-Size</th>
            <th>Embroidery Placement</th>
            <th>Custom Options</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($order['items'] as $product){?>
            <tr>
              <td><?php echo $product['sku']; ?></td>
              <td><?php echo $product['name']; ?></td>
              <td><?php echo $product['options'][1]['value']; ?></td>
              <td><?php echo $product['options'][0]['value']; ?></td>
              <td>
                <?php
                if(isset($product['customOptions'])) {
                  foreach ($product['customOptions'] as $key => $items) { ?>
                    <b><?php echo 'Item ' . $key; ?></b><br/>
                    <?php foreach ($items as $option => $value) { ?>
                      <b><?php echo $option; ?></b><?php echo $value; ?><br/>
                    <?php }
                  }
                }?>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
    </div>

  </div>
</div>
