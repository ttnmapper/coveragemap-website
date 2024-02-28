<?php
header("Location:/heatmap/");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
<body>

<!-- Image and text -->
<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="/">
        <img src="<?php echo $brandIcon; ?>" width="auto" height="32" class="d-inline-block align-top" alt="">
        Coverage Map
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
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
        <div class="navbar-nav ml-auto">
            <a href="https://docs.ttnmapper.org/support-project.html" target="_blank">
                <button class="btn btn-primary">Support the project</button>
            </a>
        </div>
    </div>

</nav>

<div class="container">



    <div class="card mt-5">
        <div class="card-header">
            Coverage Map
        </div>
        <div class="card-body">
            <p>This website shows the measured coverage for the Helium IoT LoRaWAN network.
                The coverage is measured by users of the network that do drive tests, and provide the data to this
                mapping service. Data is aggregated into a heatmap, but is also available in raw format
                under advanced maps.</p>
            <p>TTN Mapper was the first version of this site that mapped the coverage of The Things Network. The same technology is used
            in a larger scale to map the coverage of the hundreds of thousands of Helium hotspots.</p>
            <p>Please read the documentation to learn how to contribute.</p>
            <p>This service depends on donations. Please consider supporting the project.</p>
        </div>
        <ul class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" href="/heatmap/">View Helium Heatmap</a>
            <a class="list-group-item list-group-item-action" href="/advanced-maps/">Advanced Maps</a>
            <a class="list-group-item list-group-item-action" href="https://docs.ttnmapper.org" target="_blank">View Documentation</a>
            <a class="list-group-item list-group-item-action" href="https://docs.ttnmapper.org/support-project.html" target="_blank">Support the Project</a>
        </ul>
    </div>
</div>

</body>
</html>
