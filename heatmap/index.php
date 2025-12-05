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
                    <a class="nav-link" href="/heatmap/">Heatmap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/advanced-maps/">Advanced maps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://coveragemap.net">CoverageMap.net</a>
                </li>
            </ul>
        </div>

    </nav>

    <!-- The Notice (Alert) -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <a class="alert-link" href="https://www.thethingsnetwork.org/forum/t/ttn-mapper-time-to-shut-down/72749">
            Please read this important announcement regarding the CoverageMap.net (a.k.a. TTN Mapper) service.
        </a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div id="progress" style="display: none;">Loading Hotspots
        <div class="spinner-border float-right" role="status" style="height: 20px; width: 20px;">
            <span class="sr-only">Loading...</span>
        </div>
        <div id="progress-bar"></div>
    </div>

    <div id="map">
        <div id="rightcontainer">
            <div id="legend" class="dropSheet"></div>
        </div>
    </div>

    <!-- Include required libraries -->
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/foot.php'; ?>
    <!-- The actual main logic for this page -->
    <script src="index-logic.js"></script>

</body>
</html>
