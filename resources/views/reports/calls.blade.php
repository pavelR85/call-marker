@extends('layouts.app')

@section('content')

    <div class="d-flex flex-column justify-content-center w-100 h-100">
        <div class="d-flex flex-column justify-content-center align-items-center">
        <h1 class="fw-light text-white m-0">Call Report</h1>
        <form id="filter-form">
            <div>
                <label for="agent_id">Agent:</label>
                <select name="agent_id" id="agent_id">
                    <option value="">All Agents</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date">
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date">
            </div>
            <button type="submit">Filter</button>
        </form>
        <div id="update">
        <table>
            <thead>
            <tr>
                <th>Call ID</th>
                <th>Customer</th>
                <th>Agent</th>
                <th>Duration</th>
                <th>Timestamp</th>
            </tr>
            </thead>
            <tbody>
            @foreach($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->customer->name }}</td>
                    <td>{{ $call->agent->name }}</td>
                    <td>{{ $call->duration }}</td>
                    <td>{{ $call->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
            <div class="pagination">
                {{ $calls->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        paginationClick();
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = e.target;
        // Collect filter data
        let data = {
            agent_id: document.getElementById('agent_id').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
        };

        // Send AJAX request
        fetch("{{ route('reports.calls') }}?agent_id=" + document.getElementById('agent_id').value
            + "&start_date=" + document.getElementById('start_date').value
            + "&end_date=" + document.getElementById('end_date').value, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    document.getElementById('update').innerHTML = result.html;
                    //clear form
                    // document.getElementById('agent_id').value = '';
                    // document.getElementById('start_date').value = '';
                    // document.getElementById('end_date').value = '';
                    paginationClick();
                } else {
                    alert('Failed to load data.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
    });
    function paginationClick() {
        document.querySelectorAll('.pagination a').forEach((el)=>{
            el.addEventListener('click', function (e) {
                e.preventDefault();
                let form = e.target;

                // Send AJAX request
                fetch(el.getAttribute('href') + "&agent_id=" + document.getElementById('agent_id').value
                    + "&start_date=" + document.getElementById('start_date').value
                    + "&end_date=" + document.getElementById('end_date').value, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            document.getElementById('update').innerHTML = result.html;
                            paginationClick();
                        } else {
                            alert('Failed to load data.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
        });

    }
</script>
@endpush

@push('styles')
<style>
    *{
        color: #fff;
    }
    h1{
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        margin: 0 0 20px;
    }
    form{
        border: 1px #000 dotted;
        padding: 10px;
        border-radius: 10px;
    }
    form div{
        margin-bottom: 5px;
    }
    form label{
        display: inline-block;
        min-width: 150px;
    }
    form select, form input{
        width: 250px;
        border-right: 5px;
        color: #000000;
    }
    form select option{
        color: #000;
    }
    form button{
        width: 200px;
        border-radius: 8px;
        color: #fff;
        border: 1px #fff solid;
        background: green !important;
        margin: 10px auto 0;
        display: block;
    }
    svg.w-5.h-5{
        width: 23px;
        margin: 0px 0px -6px;
    }
    body {
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        height: 100vh;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

</style>
@endpush
