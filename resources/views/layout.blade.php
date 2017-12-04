<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coin Forecast</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style rel="stylesheet">
        body {
            padding-top: 20px;
        }

        .table {
            border-radius: 5px;
            width: 50%;
            margin: 0px auto;
            margin-left: -100px;
            float: left;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
            margin-right: -60px;
        }

        #shortable {
            margin-left: -30px;
        }

        .table td.fit,
        .table th.fit {
            white-space: nowrap;
            width: 1%;
        }

        .custom-text {
            margin-left: -30px;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            var oTable = $('#shortable').dataTable({
                "paging": false,
                "order": [[5, "desc"]],
            });
        });
    </script>
</body>
</html>
