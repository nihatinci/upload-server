<?php
$this->registerJsFile('@web/js/order.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/order.css');
/* @var $this yii\web\View */

$this->title = 'Confirm Your Order';
?>
<div class="site-index">

    <div class="jumbotron" style="margin-bottom:-35px; margin-top:30px";>
        <h2>Etsy Personalized Trends order details</h2>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Important</h2>
                <p>Please be sure to check the information you submit. The robes will be embroidered in the exact order of letters that you provide!<br/>
                If you paid only for 1 line and you need 2 lines please contact us immediately with your order number to process your order.
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Warnings</h2>
                <p>Each <b>Monogram</b> is 3 maximum of characters with no spacing, all in capital letters.<br/>
                Each <b>Overlay</b> is a maximum of 11 characters with no spacing.<br/>
                For <b>Name/Initial</b> orders, each line is a maximum of 11 characters including spaces.<br/>
            </p>
            </div>
            <div class="col-lg-4">
                <h2>Order Timing</h2>
                <p>All orders will take 2 weeks to deliver after the form is submitted successfully including transit time within continental United States.<br/>
                    If you selected expedited shipping your order will be delivered in 10 days.
                </p>
            </div>

        </div>

        <div class="row">
            <?php if($error !== null){ ?>
                <label><?php echo $error; ?></label>
            <?php }else{ ?>
            <form method="post" action="/order/save/<?php echo $order['orderId']; ?>">
                <label>Etsy Order Number : </label> <?php echo $order['orderNumber']; ?>
                <?php foreach($order['items'] as $key=>$item){ ?>
                    <div class="form-group">
                        <label>Product <?php echo $key+1; ?> : </label> <br/>
                        <label>Name : </label> <?php echo $item['name']; ?> <br/>
                        <?php foreach($item['options'] as $option){ ?>
                            <label><?php echo $option['name']; ?> :</label>
                            <?php echo $option['value']; ?> <br/>
                        <?php } ?>
                    </div>
                    <?php if(isset($item['optionElements'])){
                        for($i=1; $i<=$item['quantity']; $i++) { ?>
                            <label>Item  <?php echo $i; ?> : </label> <br/>
                            <?php foreach ($item['optionElements'] as $element) {
                                switch ($element['type']) {
                                    case 'dropdown': ?>
                                        <div class="form-group"
                                             id="form-<?php echo $element['class'] . '-' . $item['orderItemId'] . '-' . $i; ?>">
                                            <label
                                              for="<?php echo $element['class']; ?>"><?php echo $element['label']; ?></label>
                                            <select class="form-control <?php echo $element['class']; ?>"
                                                    id="<?php echo $element['class'] . '-' . $item['orderItemId'] . '-' . $i; ?>"
                                                    name="options[<?php echo $item['orderItemId']; ?>][<?php echo 'item-'+$i; ?>][<?php echo $element['label']; ?>]">
                                                <?php foreach ($element['options'] as $option) { ?>
                                                    <option
                                                      value="<?php echo $option; ?>"> <?php echo $option; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php
                                        break;
                                    case 'text': ?>
                                        <div class="form-group"
                                             id="form-<?php echo $element['class'] . '-' . $item['orderItemId'] . '-' . $i; ?>">
                                            <label
                                              for="<?php echo $element['class']; ?>"><?php echo $element['label']; ?></label>
                                            <input maxlength="<?php echo $element['limit']; ?>"
                                                   class="form-control <?php echo $element['class']; ?>"
                                                   id="<?php echo $element['class'] . '-' . $item['orderItemId'] . '-' . $i; ?>"
                                                   type="text" value="" required
                                                   name="options[<?php echo $item['orderItemId']; ?>][<?php echo 'item-'+$i; ?>][<?php echo $element['label']; ?>]">
                                        </div>
                                        <?php
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                    } ?>
                <?php } ?>
                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
            <?php } ?>
        </div>

    </div>
</div>
