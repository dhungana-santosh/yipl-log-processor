<html>
<head>
    <title>Summarize log</title>
</head>
<body>
<?php
$file = fopen('example.log', 'r') or die ('File opening failed');
$line = fgets($file);

while (!feof($file)) {

    $requestsCount = 1;
    $warning_count = 0;
    $error_count = 0;
    $parts = explode(' ', $line);
    $date = substr($parts[0], 0, 10);
    $message = substr($parts[7], 0, 10);
    if (messagewarning($message)) $warning_count++;
    if (messageerror($message)) $error_count++;
    l:
    $line1 = fgets($file);
    $parts1 = explode(' ', $line1);
    $date1 = substr($parts1[0], 0, 10);
    if ($date == $date1) {
        $requestsCount = 0;
        $message = substr($parts1[7], 0, 10);
        if (messagewarning($message)) $warning_count++;
        if (messageerror($message)) $error_count++;

        Goto l;
    }


    echo($date . " warning:" . $warning_count . " error:" . $error_count . "<br>");

    $line = $line1;


}
fclose($file);
function messagewarning($message)
{
    return substr_count($message, "warning") > 0;
}

function messageerror($message)
{
    return substr_count($message, "error") > 0;
}

?>
</body>
</html>
