<table>
    <thead>
    <tr>
        <th>Customer</th>
        <th>Agent</th>
        <th>Duration</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @forelse($calls as $call)
        <tr>
            <td>{{ $call->customer->name }}</td>
            <td>{{ $call->agent->name }}</td>
            <td>{{ $call->duration }} seconds</td>
            <td>{{ $call->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No calls found</td>
        </tr>
    @endforelse
    </tbody>
</table>

@if(method_exists($calls, 'links'))
    <div class="pagination">
        {{ $calls->links() }}
    </div>
@endif
