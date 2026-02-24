<?php

// 🔥 CHANGE THIS VALUE ONLY
$cashfree_mode = "TEST"; // TEST or LIVE =====================

if ($cashfree_mode == "TEST") {

    define("CASHFREE_CLIENT_ID", ".................");
    define("CASHFREE_CLIENT_SECRET", "................");
    define("CASHFREE_API_URL", "https://sandbox.cashfree.com/pg/orders");

} else {

    define("CASHFREE_CLIENT_ID", "YOUR_LIVE_CLIENT_ID");
    define("CASHFREE_CLIENT_SECRET", "YOUR_LIVE_CLIENT_SECRET");
    define("CASHFREE_API_URL", "https://api.cashfree.com/pg/orders");
}