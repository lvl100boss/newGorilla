<div class="content py-3" style="background-color: #121212; color: #ffffff;">
    <div class="card card-outline" style="border-color: #14453d; background-color: #1e1e1e; box-shadow: 0 4px 8px rgba(20, 69, 61, 0.2); border-radius: 8px;">
        <div class="card-header" style="background-color: #14453d; color: #ffffff;">
            <div class="h5 card-title">Checkout</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="" id="checkout-form">
                        <div class="form-group">
                            <label for="delivery_address" class="control-label">Delivery Address</label>
                            <textarea name="delivery_address" id="delivery_address" rows="4" class="form-control rounded-0" required><?= $_settings->userdata('address') ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-flat btn-sm" style="background-color: #14453d; color: #ffffff;">Place Order</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="row" id="summary">
                        <div class="col-12 border" style="background-color: #1e1e1e;">
                            <h2 class="text-center"><b>Summary</b></h2>
                        </div>
                        <?php
                        $gtotal = 0;
                        $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                        while ($vrow = $vendors->fetch_assoc()):
                            $vtotal = $conn->query("SELECT sum(c.quantity * p.price) FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}'")->fetch_array()[0];
                            $vtotal = $vtotal > 0 ? $vtotal : 0;
                            $gtotal += $vtotal;
                        ?>
                            <div class="col-12 border item" style="background-color: #1e1e1e; color: #ffffff;">
                                <b class="text-muted"><small><?= $vrow['code'] . " - " . $vrow['shop_name'] ?></small></b>
                                <div class="text-right"><b><?= format_num($vtotal) ?></b></div>
                            </div>
                        <?php endwhile; ?>
                        <div class="col-12 border" style="background-color: #14453d; color: #ffffff;">
                            <b class="text-muted">Grand Total</b>
                            <div class="text-right h3" id="total"><b><?= format_num($gtotal) ?></b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    body {
        background-color: #121212;
        color: #ffffff;
    }

    .btn-default {
        background-color: #14453d;
        color: #ffffff;
        border: none;
    }

    .btn-default:hover {
        background-color: #0f3b2f;
    }

    a {
        color: #14453d;
    }

    a:hover {
        color: #0f3b2f;
    }

    .form-control {
        background-color: #1e1e1e;
        color: #ffffff;
        border: 1px solid #14453d;
    }

    .form-control:focus {
        border-color: #14453d;
        box-shadow: none;
    }

    .card {
        border-radius: 8px;
    }
</style>
<script>
    $('#checkout-form').submit(function(e) {
        e.preventDefault()
        var _this = $(this)
        if (_this[0].checkValidity() == false) {
            _this[0].reportValidity()
            return false;
        }
        if ($('#summary .item').length <= 0) {
            alert_toast("There is no order listed in the cart yet.", 'error')
            return false;
        }
        $('.pop_msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger pop_msg")
        el.hide()
        start_loader()
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=place_order',
            method: 'POST',
            data: _this.serialize(),
            dataType: 'json',
            error: err => {
                console.error(err)
                alert_toast("An error occurred.", 'error')
                end_loader()
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.replace('./?page=products')
                } else if (!!resp.msg) {
                    el.text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                } else {
                    el.text("An error occurred.")
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                }
                end_loader()
            }
        })
    })
</script>