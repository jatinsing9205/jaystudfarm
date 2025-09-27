<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>


    <?php
    
    $apiKey = 'ybifcldsf dwofhwuiojkzxcadsdqeioubl'; // Replace with your OpenAI API key
    $apiUrl = 'https://api.openai.com/v1/responses'; // The API endpoint
    
    $data = [
        'model' => 'gpt-4.1',
        'input' => 'Write a one-sentence bedtime story about a unicorn.',
    ];
    
    $headers = ['Content-Type: application/json', "Authorization: Bearer $apiKey"];
    
    // Initialize cURL session
    $ch = curl_init($apiUrl);
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    // Execute the request
    $response = curl_exec($ch);
    
    // Check for errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        // Print the API response
        echo $response;
    }
    
    // Close cURL session
    curl_close($ch);
    
    ?>

    <div id="main"></div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'http://localhost/laravel/jaystudfarm/getExpectedDates/JSF0202504',
                type: 'GET',
                success: function(response) {
                    const table = $(
                        '<table cellpadding="5" cellspacing="1" border></table>');
                    response.exercise_expected_date.forEach((exercise, index) => {
                        console.log(exercise);
                        table.html(
                            `<tr>
                                <td>${index+1}</td>
                                <td>${exercise.exercise_name}</td>
                                <td>${exercise.expected_date}</td>
                                <td>${exercise.remark}</td>
                            </tr>`
                        );
                    });
                    $('#main').html(table);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        })
    </script>

</body>

</html>
