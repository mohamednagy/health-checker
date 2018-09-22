<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <meta content="{{ csrf_token() }}" name="csrf-token">
    </head>

    <style>
        #snippet {
            display: none;
        }
        hr.message-inner-separator {
            clear: both;
            margin-top: 10px;
            margin-bottom: 13px;
            border: 0;
            height: 1px;
            background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
            background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
            background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
            background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
        }

        .cssload-container {
            width: 100%;
            height: 17px;
            text-align: center;
        }

        .cssload-double-torus {
            width: 17px;
            height: 17px;
            margin: 0 auto;
            border: 1px double;
            border-radius: 50%;
            border-color: transparent rgba(166,166,166,0.9) rgba(168,168,168,0.88);
            animation: cssload-spin 570ms infinite linear;
            -o-animation: cssload-spin 570ms infinite linear;
            -ms-animation: cssload-spin 570ms infinite linear;
            -webkit-animation: cssload-spin 570ms infinite linear;
            -moz-animation: cssload-spin 570ms infinite linear;
        }

        @keyframes cssload-spin {
            100%{ transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-o-keyframes cssload-spin {
            100%{ -o-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-ms-keyframes cssload-spin {
            100%{ -ms-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-webkit-keyframes cssload-spin {
            100%{ -webkit-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-moz-keyframes cssload-spin {
            100%{ -moz-transform: rotate(360deg); transform: rotate(360deg); }
        }
    </style>

<body>
    <div class="container-fluid mt-3">
        <h3>Health Checker Dashboard</h3>
        <hr class="message-inner-separator">

        <div class="col-12 row checkers-container">
            <div id="snippet" class="col-sm-6 col-md-4">
                <div id='alert' class="alert border">
                    <a class="btn btn-default close recheck-btn" target="" aria-hidden="true">
                        <img style="width:15px;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDgyLjE5NSwyMjYuMTk2QzQ4Mi4xOTUsMTAxLjQ3MSwzODAuNzI1LDAsMjU2LjAwMSwwUzI5LjgwNSwxMDEuNDcxLDI5LjgwNSwyMjYuMTk2YzAsNy40MDksNi4wMDcsMTMuNDE2LDEzLjQxNiwxMy40MTYgICAgczEzLjQxNi02LjAwOCwxMy40MTYtMTMuNDE2YzAtMTA5LjkzLDg5LjQzNC0xOTkuMzYzLDE5OS4zNjMtMTk5LjM2M3MxOTkuMzYzLDg5LjQzNCwxOTkuMzYzLDE5OS4zNjMgICAgYzAsMTA5LjkyOC04OS40MzQsMTk5LjM2Mi0xOTkuMzYzLDE5OS4zNjJoLTIzLjI3NmwzMy4yODItMzcuMjU1YzQuOTM3LTUuNTI1LDQuNDU4LTE0LjAwNy0xLjA2Ny0xOC45NDQgICAgYy01LjUyNS00LjkzNy0xNC4wMDgtNC40NTctMTguOTQ0LDEuMDY4bC00Ny41NzYsNTMuMjU1Yy03Ljc4OCw4LjcxOC03Ljc4OCwyMS44NjYsMCwzMC41ODRsNDcuNTc2LDUzLjI1NSAgICBjMi42NTEsMi45NjgsNi4zMjIsNC40NzgsMTAuMDEsNC40NzhjMy4xODEsMCw2LjM3NS0xLjEyNiw4LjkzNC0zLjQxYzUuNTI2LTQuOTM3LDYuMDA0LTEzLjQxOSwxLjA2Ny0xOC45NDRsLTMzLjI4Mi0zNy4yNTUgICAgaDIzLjI3NkMzODAuNzI1LDQ1Mi4zOSw0ODIuMTk1LDM1MC45MTksNDgyLjE5NSwyMjYuMTk2eiIgZmlsbD0iIzAwMDAwMCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                    </a>
                    <span class="glyphicon glyphicon-ok"></span> <strong id="name">Success Message</strong>
                    <hr class="message-inner-separator">
                    <p>
                        <div id='message' class="cssload-container">
                            <div class="cssload-double-torus"></div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/health-check.js') }}"></script>
</html>
