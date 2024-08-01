@extends('layouts.app')

@section('content')
<h1>Try your Luck!</h1>
<button id="generate">Generate New Link</button>
<button id="deactivate">Deactivate Link</button>
<button id="lucky">I'm Feeling Lucky</button>
<button id="history">History</button>

<div id="result"></div>

<script>
    document.getElementById('generate').addEventListener('click', function() {
        fetch('/link/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                alert('New link: ' + data.unique_link);
            });
    });

    document.getElementById('deactivate').addEventListener('click', function() {
        fetch('/link/deactivate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ link_id: {{ $link->id }} })
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            });
    });

    document.getElementById('lucky').addEventListener('click', function() {
        fetch('/link/imfeelinglucky', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerText = `Number: ${data.number}, Result: ${data.result}, Win Amount: ${data.winAmount}`;
                updateHistory(data);
            });
    });

    document.getElementById('history').addEventListener('click', function() {
        displayHistory();
    });

    function updateHistory(result) {
        let history = JSON.parse(localStorage.getItem('history')) || [];
        history.push(result);
        if (history.length > 3) {
            history.shift();
        }
        localStorage.setItem('history', JSON.stringify(history));
    }

    function displayHistory() {
        let history = JSON.parse(localStorage.getItem('history')) || [];
        let historyHtml = '';
        history.forEach(item => {
            historyHtml += `Number: ${item.number}, Result: ${item.result}, Win Amount: ${item.winAmount}<br>`;
        });
        document.getElementById('result').innerHTML = historyHtml;
    }
</script>
@endsection
