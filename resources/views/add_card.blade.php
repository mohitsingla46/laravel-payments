<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add a New Card</h2>
        <form id="custom-payment-form">
            <div id="card-element"></div>
            <br>
            <div class="error" id="card-errors" role="alert"></div>
            <button type="submit" class="btn btn-primary">Add Card</button>
            <a href="{{ url('/') }}" class="btn btn-secondary">Back to Card List</a>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stripe = Stripe('{{ config('services.stripe.key') }}');
            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            var form = document.getElementById('custom-payment-form');
            var cardButton = document.getElementById('card-button');
            var cardErrors = document.getElementById('card-errors');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(cardElement).then(function(result) {
                    if (result.error) {
                        cardErrors.textContent = result.error.message;
                    } else {
                        fetch('/save_card', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                token: result.token.id
                            })
                        }).then(function(response) {
                            return response.json();
                        }).then(function(data) {
                            if (data.success) {
                                window.location.href = '{{ url('/') }}';
                            } else {
                                cardErrors.textContent = 'There was an error saving your card.';
                            }
                        }).catch(function(error) {
                            cardErrors.textContent = 'There was an error processing your request.';
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
