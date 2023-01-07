<!DOCTYPE html>
<html lang="en">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
<body>


<div class="container-fullwidth" style="display: flex; flex-flow: column; height: 100%;">

    <!-- Image and text -->
    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="/">
            <img src="<?php echo $brandIcon; ?>" width="auto" height="32" class="d-inline-block align-top" alt="">
            <?php echo $brandName; ?>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/heatmap/">Helium Heatmap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/advanced-maps/">Advanced maps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://ttnmapper.org">The Things Network</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://docs.ttnmapper.org">Docs</a>
                </li>
            </ul>
        </div>

        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <?php
                if (!isset($settings['menu']['teespring']) or $settings['menu']['teespring'] == true) {
                    ?>
                    <li class="nav-item mr-2">
                        <a class="nav-link" href="https://teespring.com/ttnmapper">
                            <img src="/config/teespring.svg" height="25" class="d-inline-block align-middle" alt=""
                                 title="Teespring">
                            Get the T-Shirt
                        </a>
                    </li>
                    <?php
                }

                if (!isset($settings['menu']['patreon']) or $settings['menu']['patreon'] == true) {
                    ?>
                    <li class="nav-item">
                        <a href="https://www.patreon.com/ttnmapper" data-patreon-widget-type="become-patron-button"><img
                                    src="/config/become_a_patron_button@2x.png" class="d-inline-block align-middle"
                                    alt="" height="36" title="Patreon"></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>

    </nav>

    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="private-network-warning">
        Warning: You are viewing the coverage for a private network. This will require a subscription in the future.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div id="map">
        <div id="rightcontainer">
            <div id="legend" class="dropSheet"></div>
        </div>
    </div>
</div>

<!-- Include required libraries -->
<?php require $_SERVER['DOCUMENT_ROOT'] . '/foot.php'; ?>
<!-- The actual main logic for this page -->
<script src="index-logic.js"></script>

</body>
</html>
