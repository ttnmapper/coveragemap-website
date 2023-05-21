<head>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $string = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/config/settings.json");
    $settings = json_decode($string, true);

    if (isset($settings['theming']['site_name'])) {
        $siteName = $settings['theming']['site_name'];
    } else {
        $siteName = "Coverage Map";
    }

    if (isset($settings['theming']['site_description'])) {
        $siteDescription = $settings['theming']['site_description'];
    } else {
        $siteDescription = "Map the coverage of Helium Hotspots.";
    }

    if (isset($settings['theming']['favicon_dir'])) {
        $favicons = $settings['theming']['favicon_dir'];
    } else {
        $favicons = "favicons";
    }

    if (isset($settings['theming']['brand_icon'])) {
        $brandIcon = $settings['theming']['brand_icon'];
    } else {
        $brandIcon = "/favicons/android-chrome-512x512.png";
    }

    if (isset($settings['theming']['brand_name'])) {
        $brandName = $settings['theming']['brand_name'];
    } else {
        $brandName = "Coverage Map";
    }

    if (isset($settings['analytics']['measurement_id'])) {
        $googleAnalyticsMeasurementId = $settings['analytics']['measurement_id'];
    } else {
        $googleAnalyticsMeasurementId = "UA-75921430-4";
    }

    ?>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $siteDescription; ?>"/>
    <meta name="keywords"
          content="helium coverage, the peoples network coverage, hotspot reception area, contribute to helium"/>
    <meta name="robots" content="index,follow"/>
    <meta name="author" content="JP Meijers">

    <title><?php echo $siteName; ?></title>

    <!--favicons-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicons; ?>/apple-touch-icon.png?v=20210109">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicons; ?>/favicon-32x32.png?v=20210109">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicons; ?>/favicon-16x16.png?v=20210109">
    <link rel="manifest" href="<?php echo $favicons; ?>/site.webmanifest?v=20210109">
    <link rel="mask-icon" href="<?php echo $favicons; ?>/safari-pinned-tab.svg?v=20210109" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo $favicons; ?>/favicon.ico?v=20210109">
    <meta name="apple-mobile-web-app-title" content="TTN Mapper">
    <meta name="application-name" content="TTN Mapper">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-config" content="<?php echo $favicons; ?>/browserconfig.xml?v=20210109">
    <meta name="theme-color" content="#ffffff">


    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.css"
          integrity="sha256-AghQEDQh6JXTN1iI/BatwbIHpJRKQcg2lay7DE5U/RQ=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="/libs/open-iconic/font/css/open-iconic-bootstrap.min.css"/>

    <!-- Page theme -->
    <link rel="stylesheet" href="/theme.css"/>

    <!-- Leaflet -->
    <link rel="stylesheet" href="/libs/leaflet-1.9.3/leaflet.css"/>
    <link rel="stylesheet" href="/libs/Leaflet.markercluster/dist/MarkerCluster.css"/>
    <link rel="stylesheet" href="/libs/Leaflet.markercluster/dist/MarkerCluster.Default.css"/>
    <link rel="stylesheet" href="/libs/leaflet.measure/leaflet.measure.css"/>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $googleAnalyticsMeasurementId; ?>">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', '<?php echo $googleAnalyticsMeasurementId; ?>');
    </script>

    <!-- Google ads verification -->
<!--    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4919960117739141"-->
<!--            crossorigin="anonymous"></script>-->

    <!-- Quantcast Choice. Consent Manager Tag v2.0 (for TCF 2.0) -->
    <script type="text/javascript" async=true>
        (function() {
            var host = 'www.themoneytizer.com';
            var element = document.createElement('script');
            var firstScript = document.getElementsByTagName('script')[0];
            var url = 'https://cmp.quantcast.com'
                .concat('/choice/', '6Fv0cGNfc_bw8', '/', host, '/choice.js');
            var uspTries = 0;
            var uspTriesLimit = 3;
            element.async = true;
            element.type = 'text/javascript';
            element.src = url;

            firstScript.parentNode.insertBefore(element, firstScript);

            function makeStub() {
                var TCF_LOCATOR_NAME = '__tcfapiLocator';
                var queue = [];
                var win = window;
                var cmpFrame;

                function addFrame() {
                    var doc = win.document;
                    var otherCMP = !!(win.frames[TCF_LOCATOR_NAME]);

                    if (!otherCMP) {
                        if (doc.body) {
                            var iframe = doc.createElement('iframe');

                            iframe.style.cssText = 'display:none';
                            iframe.name = TCF_LOCATOR_NAME;
                            doc.body.appendChild(iframe);
                        } else {
                            setTimeout(addFrame, 5);
                        }
                    }
                    return !otherCMP;
                }

                function tcfAPIHandler() {
                    var gdprApplies;
                    var args = arguments;

                    if (!args.length) {
                        return queue;
                    } else if (args[0] === 'setGdprApplies') {
                        if (
                            args.length > 3 &&
                            args[2] === 2 &&
                            typeof args[3] === 'boolean'
                        ) {
                            gdprApplies = args[3];
                            if (typeof args[2] === 'function') {
                                args[2]('set', true);
                            }
                        }
                    } else if (args[0] === 'ping') {
                        var retr = {
                            gdprApplies: gdprApplies,
                            cmpLoaded: false,
                            cmpStatus: 'stub'
                        };

                        if (typeof args[2] === 'function') {
                            args[2](retr);
                        }
                    } else {
                        if(args[0] === 'init' && typeof args[3] === 'object') {
                            args[3] = { ...args[3], tag_version: 'V2' };
                        }
                        queue.push(args);
                    }
                }

                function postMessageEventHandler(event) {
                    var msgIsString = typeof event.data === 'string';
                    var json = {};

                    try {
                        if (msgIsString) {
                            json = JSON.parse(event.data);
                        } else {
                            json = event.data;
                        }
                    } catch (ignore) {}

                    var payload = json.__tcfapiCall;

                    if (payload) {
                        window.__tcfapi(
                            payload.command,
                            payload.version,
                            function(retValue, success) {
                                var returnMsg = {
                                    __tcfapiReturn: {
                                        returnValue: retValue,
                                        success: success,
                                        callId: payload.callId
                                    }
                                };
                                if (msgIsString) {
                                    returnMsg = JSON.stringify(returnMsg);
                                }
                                if (event && event.source && event.source.postMessage) {
                                    event.source.postMessage(returnMsg, '*');
                                }
                            },
                            payload.parameter
                        );
                    }
                }

                while (win) {
                    try {
                        if (win.frames[TCF_LOCATOR_NAME]) {
                            cmpFrame = win;
                            break;
                        }
                    } catch (ignore) {}

                    if (win === window.top) {
                        break;
                    }
                    win = win.parent;
                }
                if (!cmpFrame) {
                    addFrame();
                    win.__tcfapi = tcfAPIHandler;
                    win.addEventListener('message', postMessageEventHandler, false);
                }
            };

            makeStub();

            var uspStubFunction = function() {
                var arg = arguments;
                if (typeof window.__uspapi !== uspStubFunction) {
                    setTimeout(function() {
                        if (typeof window.__uspapi !== 'undefined') {
                            window.__uspapi.apply(window.__uspapi, arg);
                        }
                    }, 500);
                }
            };

            var checkIfUspIsReady = function() {
                uspTries++;
                if (window.__uspapi === uspStubFunction && uspTries < uspTriesLimit) {
                    console.warn('USP is not accessible');
                } else {
                    clearInterval(uspInterval);
                }
            };

            if (typeof window.__uspapi === 'undefined') {
                window.__uspapi = uspStubFunction;
                var uspInterval = setInterval(checkIfUspIsReady, 6000);
            }
        })();
    </script>
    <!-- End Quantcast Choice. Consent Manager Tag v2.0 (for TCF 2.0) -->
</head>
