@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Transfers</h1>
@stop

@section('content')
    <table class="table table-hover table-bordered" style="background-color: white">
    	<thead>
    		<tr>
    			<th>S</th>
    			<th>Sender</th>
    			<th>Receiver</th>
    			<th>Amount</th>
    			<th>Actions</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($transfers as $transfer)
				<tr>
	    			<td>{{ $loop->iteration }}</td>
	    			<td>{{ $transfer->sender->name }}</td>
	    			<td>{{ $transfer->receiver->name }}</td>
	    			<td>{{ number_format($transfer->amount, 2) }}</td>
	    			<td>
	    				@if($transfer->status == 0)
							<form method="post" action="{{ route('transfers.confirm', $transfer) }}">
		    					@csrf
		    					<button type="submit" class="btn btn-primary">Confirm</button>
		    				</form>
	    				@else
							Confirmed!
	    				@endif
	    			</td>
	    		</tr>
    		@endforeach
    	</tbody>
    </table>
@stop