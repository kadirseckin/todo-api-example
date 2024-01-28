<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Assigned Tasks</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Developers</th>
                <th scope="col">Task Count</th>
                <th scope="col">Tasks</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assignedTasks as $developerName => $tasks)
                <tr>
                    <td>{{ $developerName }}</td>
                    <td>{{ count($tasks) }}</td>
                    <td>
                        <ul class="list-unstyled">
                            @foreach ($tasks as $task)
                                <li>{{ $task }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
