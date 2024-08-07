<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-primary mt-4" href="{{ url('add_card') }}">Add New Card</a>
                @foreach ($cards as $index => $card)
                    <div class="card mb-3 mt-2" id="card{{ $index }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <img src="{{ Config::get('constants')[$card->card->brand] }}" alt="{{ $card->card->brand }}"
                                        style="width: 40px;">
                                    <div class="card_id" style="display: none;">{{ $card->id }}</div>
                                </div>
                                <div class="col-sm-3">
                                    <p class="card-text">**** **** **** {{ $card->card->last4 }}</p>
                                </div>
                                <div class="col-sm-7" style="text-align: right">
                                    <button class="btn btn-success"
                                        onclick="selectCard('card{{ $index }}')">Select
                                        Card</button>
                                    <a class="btn btn-danger" href="{{url('delete_card', $card->id)}}">Delete Card</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-5 d-none text-center" id="paymentSection">
                    <h2>Proceed to Payment</h2>
                    <form action="{{ url('doPayment') }}" method="POST">
                        @csrf
                        <input name="amount" type="hidden" value="{{ $payment['amount'] }}" />
                        <input name="currency" type="hidden" value="{{ $payment['currency'] }}" />
                        <input id="card_id" name="card" type="hidden" value="" />
                        <p>Selected Card: <span id="selectedCard"></span></p>
                        <p>Amount: {{ $payment['display_currency'] . $payment['amount'] }}</p>
                        <button class="btn btn-success" type="submit">Proceed to Payment</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction['user']['name'] }}</td>
                                <td>{{ $transaction['stripe_transaction_id'] }}</td>
                                <td>{{ $payment['display_currency'] . $transaction['amount']/100 }}</td>
                                <td>{{ $transaction['status'] == 1 ? 'Success' : 'Failed' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function selectCard(cardId) {
            const selectedCard = document.querySelector(`#${cardId} .card-text`).innerText;
            document.getElementById('selectedCard').innerText = selectedCard;
            document.getElementById('paymentSection').classList.remove('d-none');
            const card_id = document.querySelector(`#${cardId} .card_id`).innerText;
            document.getElementById('card_id').value = card_id;
        }
    </script>
</body>

</html>
