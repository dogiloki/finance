<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Amortizaciones</title>
</head>
<body>

	<h1>Calculadora de Amortizaciones</h1>
	<a href="{{route('loan.form')}}">Préstamos</a>
	<a href="{{route('credit.form')}}">Créditos</a>

	@if(Route::is('credit.form'))
		<form action="{{route('credit_calcule')}}" method="POST">
	@else
		<form action="{{route('loan_calcule')}}" method="POST">
	@endif
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
			<span>Tipo de pago</span>
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

		<h2>Resumen</h2>
		<table>
			<tr>
				<th align="left">Importe financiero</th>
				<td>{{$table->getValueFormatAt(0,'balance')}}</td>
			</tr>
			<tr>
				<th align="left">Periodicidad del pago</th>
				<td>{{$loan_option->paymentFrequency->name}}</td>
			</tr>
			<tr>
				<th align="left">Plazo</th>
				<td>{{$loan_option->term}}</td>
			</tr>
			<tr>
				<th align="left">Vencimiento en día específico</th>
				<td>{{$loan_option->day_maturity}}</td>
			</tr>
			<tr>
				<th align="left">Tasa de interés</th>
				<td>{{$loan_option->interest}} %</td>
			</tr>
			<tr>
				<th align="left">Tipo</th>
				<td>{{$loan_option->loanType->name}}</td>
			</tr>
			<tr>
				<th align="left">Comisión</th>
				<td>{{$loan_option->commission}} %</td>
			</tr>
			<tr>
				<th align="left">IVA sobre interés</th>
				<td>{{$loan_option->interest_vat}} %</td>
			</tr>
			<tr>
				<th align="left">Fecha de operación</th>
				<td>{{$loan_option->transaction_at}}</td>
			</tr>
		</table>

		<h3>Totales</h3>

		<table>
			<tr>
				<th align="left">Amortización</th>
				<td>{{$table->totals['amortization']}}</td>
			</tr>
			<tr>
				<th align="left">Intereses</th>
				<td>{{$table->totals['interest']}}</td>
			</tr>
			<tr>
				<th align="left">IVA</th>
				<td>{{$table->totals['vat']}}</td>
			</tr>
			@if(isset($table->totals['delinquent']))
				<tr>
					<th align="left">Moratarios</th>
					<td>{{$table->totals['delinquent']}}</td>
				</tr>
				<tr>
					<th align="left">Flujo</th>
					<td>{{$table->totals['total_payment']}}</td>
				</tr>
			@else
				<tr>
					<th align="left">Pago total</th>
					<td>{{$table->totals['total_payment']}}</td>
				</tr>
			@endif
		</table>

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
				@foreach($table->getRowsFormat() as $row)
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