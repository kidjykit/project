<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <ul>
    <h1>Hello , <?php echo $myname.' age : '.$age; ?></h1>

    <!-- P2 -->
    @foreach($tasks as $task)
            <li> {{ $task->body }}</li>
        @endforeach
    </ul>
</body>
</html>