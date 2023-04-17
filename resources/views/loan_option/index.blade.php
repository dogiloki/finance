<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Prestamos</title>
</head>
<body>

	<h1>Calculadora de prestamos</h1>

	<form action="{{route('loan_calcule')}}" method="POST">
		@csrf
		<label>
			<span>Monto</span>
			<input type="nombre" name="amount" required>
		</label>
		<label>
			<span>Periodicidad del pago</span>
			<select name="id_payment_frequency" required>
				@foreach($payment_frequencies as $payment_frequency)
					<option value="{{$payment_frequency->id}}">{{$payment_frequency->name}}</option>
				@endforeach
			</select>
		</label>
		<label>
			<span>Plazo</span>
			<input type="number" name="term" required>
		</label>
		<label>
			<span>Día de vencimiento</span>
			<input type="number" name="day_maturity" id="day_maturity" required>
		</label>
		<label>
			<span>Tasa de interés</span>
			<input type="number" name="interest" value="{{$interest}}" readonly required>
		</label>
		<label>
			<span>Tipo de prestamo</span>
			<select name="id_loan_type" required>
				@foreach($loan_types as $loan_type)
					<option value="{{$loan_type->id}}" title="{{$loan_type->description}}">{{$loan_type->name}}</option>
				@endforeach
			</select>
		</label>
		<label>
			<span>Fecha de inicio</span>
			<input type="date" name="transaction_at" id="transaction_at" value="{{date('Y-m-d')}}" required>
		</label>
		<input type="submit" value="Calcular">
	</form>
	@if(isset($table))
		<h2>Tabla de pagos</h2>
		<table>
			<thead>
				<tr>
					@foreach($table->getColumns() as $column)
						<th>{{$column}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($table->getRows() as $row)
					<tr>
						@foreach($row as $column)
							<td>{{$column}}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif

</body>
</html>