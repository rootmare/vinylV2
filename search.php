<?php include './includes/header.php'; ?>

<main>
    <div id="top_box">
        <!-- logo -->
        <div id="spacing">
            <a href="landing_page.php"><img src="./images/logo_music_online.jpg" alt="music online logo" id="logo"></a>
        </div>
        <!-- searching -->
        <div id="searching">
            <form action="search_results.php" method="get" id="search_box">
                <input type="text" id="item_name" name="item_name" placeholder="Search">
            </form>
        </div>
        <!-- login button -->
        <form action="logout.php" method="post" style="text-align:right;">
            <button type="submit">Logout</button>
        </form>
    </div>
    <br>
    <br>
    <section class="customer-form">
        <h2>Search Items</h2>

        <form action="search_results.php" method="get">

            <label for="item_name">Item Name</label>
            <input type="text" id="item_name" name="item_name">

            <label for="category">Category</label>
            <input type="text" id="category" name="category">

            <label for="details">Keywords</label>
            <input type="text" id="details" name="details">

            <button type="submit">Search</button>
        </form>
    </section>
</main>

<?php include './includes/footer.php'; ?>