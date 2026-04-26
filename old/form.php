<?php

include './includes/header.php';

$page_title = 'form';

?>

<section class="customer-form">
        <h2>Customer Details</h2>

        <form action="insert.php" method="post">
            
            <fieldset>
                <legend>Personal Information</legend>

                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Telephone</label>
                <input type="text" id="phone" name="phone">
            </fieldset>

            <fieldset>
                <legend>Address Details</legend>

                <label for="address">Address</label>
                <input type="text" id="address" name="address">

                <label for="city">City / Town</label>
                <input type="text" id="city" name="city">

                <label for="county">County</label>
                <input type="text" id="county" name="county">

                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode">

                <label for="notes">notes</label>
                <input type="text" id="notes" name="notes">
            </fieldset>

            <button type="submit">Submit</button>
        </form>
    </section>