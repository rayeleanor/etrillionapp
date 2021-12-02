Please wait, connecting with RedPay....
<html>
<head>
    <script>
        function submitJazzcashForm() {
            var redpay = document.forms.redpay;
            redpay.submit();
        }
    </script>
</head>
<body onload="submitJazzcashForm()">
    <form action="<?php echo $api_url; ?>" method="post" name="redpay">
        <?php foreach ($post_data as $key => $value) { ?>
            <input type="hidden" name="<?php echo $key;?>" value="<?php echo $value; ?>">
        <?php } ?>
    </form>
</body>
</html>
